@extends('layouts.siswa', ['hideNav' => true])
@section('title', 'Form Presensi - SMKN 5 Pekanbaru')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .map-container { height: 220px; width: 100%; border-radius: 1.5rem; overflow: hidden; border: 2px solid #e2e8f0; }
        #map { height: 100%; width: 100%; }
    </style>
@endsection

@section('content')
    @include('siswa.partials.header_menu', ['title' => 'Form Presensi', 'backUrl' => url('/siswa/absensi')])
    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">
        <main class="flex-1 p-4 sm:p-6 pb-36">
            <div class="max-w-2xl mx-auto space-y-5">
                {{-- Card Map --}}
                <div class="bg-white dark:bg-gray-800 p-3 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="map-container"><div id="map"></div></div>
                    <div class="p-3 flex items-center gap-3">
                        <div class="h-10 w-10 rounded-2xl bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">my_location</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Lokasi</p>
                            <p id="location-text" class="text-xs font-bold text-slate-700 dark:text-white truncate">Menunggu izin GPS...</p>
                        </div>
                        <div id="distance-badge" class="hidden px-3 py-1.5 rounded-xl bg-slate-900 text-white text-[10px] font-black">- m</div>
                    </div>
                </div>

                {{-- Form --}}
                <form id="absensiForm" action="{{ url('/siswa/absensi/store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="latitude" id="lat-input">
                    <input type="hidden" name="longitude" id="lng-input">
                    <input type="hidden" name="jarak" id="dist-input">

                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm p-6 space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-1">Hari & Tanggal</label>
                            <input type="text" value="{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}" readonly
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-1">Status Kehadiran</label>
                            <select id="statusKehadiran" name="status_kehadiran"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-bold">
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                        <div id="buktiIzinContainer" class="space-y-2 hidden">
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-1">Unggah Bukti</label>
                            <input type="file" name="bukti" class="block w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary" />
                        </div>
                    </div>

                    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-t p-4 pb-8">
                        <div class="max-w-2xl mx-auto">
                            <button type="submit" id="btnSubmit" disabled
                                class="w-full flex items-center justify-center gap-3 rounded-2xl bg-slate-300 py-4 text-sm font-black text-white shadow-lg cursor-not-allowed uppercase tracking-widest">
                                <span id="btnText">Mencari Lokasi...</span>
                                <span class="material-symbols-outlined">send</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Data dari server
        const destLat = {{ $pkl->industri->latitude ?? 0 }};
        const destLng = {{ $pkl->industri->longitude ?? 0 }};
        const radiusMaks = 50; // meter

        // Cegah error jika koordinat industri tidak valid
        if (destLat === 0 || destLng === 0) {
            Swal.fire('Error', 'Koordinat industri belum diatur oleh administrator.', 'error').then(() => window.history.back());
            throw new Error('Invalid destination coordinates');
        }

        let map, userMarker, circle;
        let currentDistance = null;

        // Inisialisasi map dengan titik industri dan lingkaran radius
        function initMap() {
            map = L.map('map').setView([destLat, destLng], 17);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            // Marker industri
            L.marker([destLat, destLng], { icon: L.divIcon({ className: 'custom-marker', html: '🏭', iconSize: [24,24] }) }).addTo(map);
            // Lingkaran radius 50 meter
            circle = L.circle([destLat, destLng], { color: '#3b82f6', weight: 2, radius: radiusMaks }).addTo(map);
        }

        // Hitung jarak (meter)
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        }

        // Update UI berdasarkan status dan jarak
        function updateUI(distance) {
            const status = document.getElementById('statusKehadiran').value;
            const distanceMeter = Math.round(distance);
            document.getElementById('dist-input').value = distanceMeter;
            document.getElementById('distance-badge').classList.remove('hidden');
            document.getElementById('distance-badge').innerText = distanceMeter + " m";

            if (status === 'Hadir') {
                if (distance <= radiusMaks) {
                    document.getElementById('location-text').innerHTML = "✅ Dalam radius industri (" + distanceMeter + " m)";
                    document.getElementById('location-text').className = "text-xs font-bold text-green-600";
                    document.getElementById('btnSubmit').disabled = false;
                    document.getElementById('btnSubmit').classList.remove('bg-slate-300', 'bg-green-600');
                    document.getElementById('btnSubmit').classList.add('bg-green-600');
                    document.getElementById('btnText').innerText = "Kirim Presensi";
                } else {
                    document.getElementById('location-text').innerHTML = "❌ Luar radius (maks 50 m) - Jarak " + distanceMeter + " m";
                    document.getElementById('location-text').className = "text-xs font-bold text-red-500";
                    document.getElementById('btnSubmit').disabled = true;
                    document.getElementById('btnSubmit').classList.remove('bg-green-600', 'bg-slate-300');
                    document.getElementById('btnSubmit').classList.add('bg-slate-300');
                    document.getElementById('btnText').innerText = "Terlalu Jauh";
                }
            } else {
                document.getElementById('location-text').innerHTML = "⏩ Lokasi diabaikan (Izin/Sakit)";
                document.getElementById('location-text').className = "text-xs font-bold text-slate-500";
                document.getElementById('btnSubmit').disabled = false;
                document.getElementById('btnSubmit').classList.remove('bg-slate-300');
                document.getElementById('btnSubmit').classList.add('bg-primary');
                document.getElementById('btnText').innerText = "Kirim Laporan";
            }
        }

        // Tambahkan marker user ke map
        function addUserMarker(lat, lng) {
            if (userMarker) map.removeLayer(userMarker);
            userMarker = L.marker([lat, lng], { icon: L.divIcon({ className: 'user-marker', html: '📍', iconSize: [24,24] }) }).addTo(map);
            map.setView([lat, lng], 17);
        }

        // Minta dan dapatkan lokasi
        function getLocation() {
            Swal.fire({
                title: 'Mengakses Lokasi',
                text: 'Aktifkan GPS dan izinkan akses lokasi untuk presensi.',
                icon: 'info',
                confirmButtonText: 'Izinkan',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Mendapatkan posisi...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            Swal.close();
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            document.getElementById('lat-input').value = lat;
                            document.getElementById('lng-input').value = lng;
                            const distance = calculateDistance(lat, lng, destLat, destLng);
                            currentDistance = distance;
                            addUserMarker(lat, lng);
                            updateUI(distance);
                        },
                        (error) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Mendapatkan Lokasi',
                                text: error.code === 1 ? 'Izin lokasi ditolak. Silakan aktifkan izin lokasi di browser.' :
                                       error.code === 2 ? 'Posisi tidak tersedia. Pastikan GPS aktif.' :
                                       'Waktu habis. Coba lagi di area terbuka.',
                                confirmButtonText: 'Coba Lagi'
                            }).then(() => getLocation());
                        },
                        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    );
                }
            });
        }

        // Saat status kehadiran berubah
        document.getElementById('statusKehadiran').addEventListener('change', function() {
            document.getElementById('buktiIzinContainer').classList.toggle('hidden', this.value === 'Hadir');
            if (currentDistance !== null) {
                updateUI(currentDistance);
            } else {
                // Jika belum dapat lokasi, minta ulang
                getLocation();
            }
        });

        // Mulai: inisialisasi map, lalu minta lokasi
        initMap();
        getLocation();
    </script>
@endsection
