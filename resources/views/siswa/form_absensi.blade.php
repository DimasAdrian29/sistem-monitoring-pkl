@extends('layouts.siswa', ['hideNav' => true])
@section('title', 'Form Presensi - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Form Presensi',
        'backUrl' => url('/siswa/absensi'),
    ])

    {{-- Leaflet CSS dimuat di sini, DALAM section content, bukan styles --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map {
            height: 220px;
            width: 100%;
        }
    </style>

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">
        <main class="flex-1 p-4 sm:p-6 pb-36">
            <div class="max-w-2xl mx-auto space-y-5">

                {{-- Card Map --}}
                <div class="bg-white dark:bg-gray-800 p-3 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="rounded-[1.5rem] overflow-hidden border-2 border-slate-200" style="height:220px;">
                        <div id="map" style="height:100%;width:100%;"></div>
                    </div>
                    <div class="p-3 flex items-center gap-3 mt-1">
                        <div class="h-10 w-10 rounded-2xl bg-blue-50 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-blue-500">my_location</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Lokasi</p>
                            <p id="location-text" class="text-xs font-bold text-slate-700 dark:text-white truncate">Menunggu
                                izin GPS...</p>
                        </div>
                        <div id="distance-badge"
                            class="hidden px-3 py-1.5 rounded-xl bg-slate-900 text-white text-[10px] font-black">- m</div>
                    </div>
                </div>

                {{-- Form --}}
                <form id="absensiForm" action="{{ route('siswa.absensi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
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
                                class="w-full rounded-2xl border border-slate-200 bg-white dark:bg-gray-700 px-4 py-3.5 text-sm font-bold">
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>

                        <div id="buktiIzinContainer" class="space-y-2 hidden">
                            <label class="text-[10px] font-bold text-slate-500 uppercase ml-1">Unggah Bukti (Hanya JPG/PNG)</label>
                            <input type="file" name="bukti" id="buktiInput" accept="image/jpeg, image/png, image/jpg"
                                class="block w-full text-xs text-slate-500
                                          file:mr-2 file:py-2 file:px-4 file:rounded-xl
                                          file:border-0 file:text-xs file:font-bold
                                          file:bg-blue-50 file:text-blue-600" />
                        </div>
                    </div>

                    {{-- Tombol Submit Fixed --}}
                    <div
                        class="fixed bottom-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-slate-200 p-4 pb-8">
                        <div class="max-w-2xl mx-auto">
                            <button type="submit" id="btnSubmit" disabled
                                class="w-full flex items-center justify-center gap-3 rounded-2xl py-4 text-sm font-black text-white shadow-lg uppercase tracking-widest transition-colors duration-200 bg-slate-300 cursor-not-allowed">
                                <span id="btnText">Mencari Lokasi...</span>
                                <span class="material-symbols-outlined text-base">send</span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </main>
        {{-- Loading Overlay --}}
        <div id="loadingOverlay"
            class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 mx-6 flex flex-col items-center gap-4 shadow-2xl">
                {{-- Spinner --}}
                <div class="relative w-16 h-16">
                    <div class="absolute inset-0 rounded-full border-4 border-slate-200"></div>
                    <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-blue-500 animate-spin">
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-500 text-2xl">send</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest">Mengirim Presensi
                    </p>
                    <p class="text-xs text-slate-400 mt-1">Mohon tunggu sebentar...</p>
                </div>
                {{-- Progress bar animasi --}}
                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full animate-[loading_1.5s_ease-in-out_infinite]"
                        style="animation: loadingBar 1.5s ease-in-out infinite;"></div>
                </div>
            </div>
        </div>

        <style>
            @keyframes loadingBar {
                0% {
                    width: 0%;
                    margin-left: 0;
                }

                50% {
                    width: 70%;
                    margin-left: 15%;
                }

                100% {
                    width: 0%;
                    margin-left: 100%;
                }
            }
        </style>
    </div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ─── Data dari server ───────────────────────────────────────────
        const destLat = {{ (float) ($pkl->industri->latitude ?? 0) }};
        const destLng = {{ (float) ($pkl->industri->longitude ?? 0) }};
        const radiusMaks = 200;

        // Guard jika koordinat belum diisi admin
        if (destLat === 0 || destLng === 0) {
            Swal.fire('Error', 'Koordinat industri belum diatur oleh administrator.', 'error')
                .then(() => window.history.back());
            throw new Error('Koordinat industri tidak valid.');
        }

        // ─── Variabel state ─────────────────────────────────────────────
        let map, userMarker;
        let currentDistance = null;

        // ─── Inisialisasi Peta ──────────────────────────────────────────
        function initMap() {
            // Pastikan container sudah ada di DOM
            map = L.map('map', {
                    zoomControl: true,
                    attributionControl: false
                })
                .setView([destLat, destLng], 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            // Marker industri
            const iconIndustri = L.divIcon({
                html: '<div style="font-size:20px;line-height:1;">🏭</div>',
                className: '',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });
            L.marker([destLat, destLng], {
                    icon: iconIndustri
                })
                .addTo(map)
                .bindPopup('Lokasi Industri');

            // Lingkaran radius
            L.circle([destLat, destLng], {
                color: '#3b82f6',
                fillColor: '#93c5fd',
                fillOpacity: 0.15,
                weight: 2,
                radius: radiusMaks
            }).addTo(map);
        }

        // ─── Hitung Jarak Haversine ─────────────────────────────────────
        function hitungJarak(lat1, lon1, lat2, lon2) {
            const R = 6371e3;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) ** 2;
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }

        // ─── Update UI ──────────────────────────────────────────────────
        function updateUI(distance) {
            const status = document.getElementById('statusKehadiran').value;
            const jarakMeter = Math.round(distance);
            const locText = document.getElementById('location-text');
            const badge = document.getElementById('distance-badge');
            const btn = document.getElementById('btnSubmit');
            const btnTxt = document.getElementById('btnText');

            document.getElementById('dist-input').value = jarakMeter;
            badge.classList.remove('hidden');
            badge.innerText = jarakMeter + ' m';

            if (status === 'Hadir') {
                if (distance <= radiusMaks) {
                    locText.innerHTML = '✅ Dalam radius industri (' + jarakMeter + ' m)';
                    locText.className = 'text-xs font-bold text-green-600';
                    btn.disabled = false;
                    btn.className = btn.className
                        .replace('bg-slate-300', '')
                        .replace('bg-red-400', '')
                        .replace('cursor-not-allowed', '') + ' bg-green-600';
                    btnTxt.innerText = 'Kirim Presensi';
                } else {
                    locText.innerHTML = '❌ Di luar radius — jarak ' + jarakMeter + ' m (maks ' + radiusMaks + ' m)';
                    locText.className = 'text-xs font-bold text-red-500';
                    btn.disabled = true;
                    btn.className = btn.className
                        .replace('bg-green-600', '')
                        .replace('bg-blue-600', '') + ' bg-slate-300 cursor-not-allowed';
                    btnTxt.innerText = 'Terlalu Jauh';
                }
            } else {
                // Izin / Sakit — lokasi tidak divalidasi
                locText.innerHTML = '⏩ Lokasi diabaikan (' + status + ')';
                locText.className = 'text-xs font-bold text-slate-500';
                btn.disabled = false;
                btn.className = btn.className
                    .replace('bg-slate-300', '')
                    .replace('bg-green-600', '')
                    .replace('cursor-not-allowed', '') + ' bg-blue-600';
                btnTxt.innerText = 'Kirim Laporan';
            }
        }

        // ─── Tambah Marker User ─────────────────────────────────────────
        function tambahMarkerUser(lat, lng) {
            if (userMarker) map.removeLayer(userMarker);
            const iconUser = L.divIcon({
                html: '<div style="font-size:20px;line-height:1;">📍</div>',
                className: '',
                iconSize: [24, 24],
                iconAnchor: [12, 24]
            });
            userMarker = L.marker([lat, lng], {
                    icon: iconUser
                })
                .addTo(map)
                .bindPopup('Lokasi Anda');
            map.setView([lat, lng], 17);
        }

        // ─── Ambil Lokasi GPS ───────────────────────────────────────────
        function getLocation() {
            Swal.fire({
                title: 'Izin Lokasi',
                text: 'Aktifkan GPS dan izinkan akses lokasi untuk presensi.',
                icon: 'info',
                confirmButtonText: 'Izinkan',
                allowOutsideClick: false
            }).then(result => {
                if (!result.isConfirmed) return;

                Swal.fire({
                    title: 'Mendapatkan posisi...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });

                navigator.geolocation.getCurrentPosition(
                    position => {
                        Swal.close();
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        document.getElementById('lat-input').value = lat;
                        document.getElementById('lng-input').value = lng;

                        const jarak = hitungJarak(lat, lng, destLat, destLng);
                        currentDistance = jarak;

                        tambahMarkerUser(lat, lng);
                        updateUI(jarak);
                    },
                    error => {
                        const pesan = {
                            1: 'Izin lokasi ditolak. Aktifkan izin lokasi di browser.',
                            2: 'Posisi tidak tersedia. Pastikan GPS aktif.',
                            3: 'Waktu habis. Coba di area lebih terbuka.'
                        } [error.code] || 'Gagal mendapatkan lokasi.';

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: pesan,
                            confirmButtonText: 'Coba Lagi'
                        }).then(() => getLocation());
                    }, {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    }
                );
            });
        }

        // ─── Event: Ganti Status Kehadiran ──────────────────────────────
        document.getElementById('statusKehadiran').addEventListener('change', function() {
            document.getElementById('buktiIzinContainer')
                .classList.toggle('hidden', this.value === 'Hadir');

            if (currentDistance !== null) {
                updateUI(currentDistance);
            } else {
                getLocation();
            }
        });

        // ─── Event: Validasi Upload Bukti Foto (JPG/PNG) ────────────────
        document.getElementById('buktiInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Valid',
                        text: 'Bukti harus berupa foto dengan format JPG atau PNG!',
                        confirmButtonText: 'Pilih Ulang',
                        confirmButtonColor: '#3b82f6',
                        customClass: {
                            confirmButton: 'rounded-xl px-6 py-2'
                        }
                    });
                    this.value = ''; // Reset input agar user harus mengupload ulang
                }
            }
        });

        // ─── Loading saat Submit ────────────────────────────────────
        document.getElementById('absensiForm').addEventListener('submit', function() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        });

        // ─── Boot ───────────────────────────────────────────────────────
        // Leaflet butuh container sudah ter-render. Tunggu DOMContentLoaded.
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            getLocation();
        });
    </script>
@endsection
