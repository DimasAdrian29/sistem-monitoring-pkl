@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Input Presensi - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Form Presensi',
        'backUrl' => url('/siswa/absensi')
    ])

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">

        <div class="w-full shrink-0">
            <div class="relative w-full h-44 sm:h-64 bg-slate-200 dark:bg-gray-700">
                <div class="w-full h-full bg-cover bg-center opacity-80"
                     style="background-image: url('https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/101.45,0.533,15,0/600x400?access_token=YOUR_TOKEN');">
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <span class="material-symbols-outlined text-red-600 text-4xl drop-shadow-md" style="font-variation-settings: 'FILL' 1;">location_on</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 border-b border-slate-100 dark:border-gray-700 py-3 px-4 sm:px-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">my_location</span>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lokasi Presensi</p>
                    <p class="text-sm font-medium text-slate-700 dark:text-white truncate">Bios Komputer - Pekanbaru</p>
                </div>
            </div>
        </div>

        <main class="flex-1 p-4 sm:p-6 pb-36">
            <div class="max-w-2xl mx-auto">
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 space-y-6">

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1">Tanggal</label>
                            <input type="text" value="{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}" readonly
                                   class="w-full rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-100 dark:bg-gray-700/50 px-4 py-3.5 text-sm font-semibold text-slate-500 outline-none cursor-not-allowed">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1">Jam Masuk</label>
                                <div class="relative">
                                    <select class="w-full appearance-none rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-50 dark:bg-gray-700 px-4 py-3.5 text-sm font-bold text-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                        @for($h = 6; $h <= 19; $h++)
                                            <option value="{{ sprintf('%02d:00', $h) }}" {{ $h == 8 ? 'selected' : '' }}>{{ sprintf('%02d:00', $h) }} WIB</option>
                                        @endfor
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1">Jam Keluar</label>
                                <div class="relative">
                                    <select class="w-full appearance-none rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-50 dark:bg-gray-700 px-4 py-3.5 text-sm font-bold text-slate-700 dark:text-white focus:ring-2 focus:ring-primary/20 outline-none">
                                        <option value="">--:--</option>
                                        @for($h = 10; $h <= 21; $h++)
                                            <option value="{{ sprintf('%02d:00', $h) }}" {{ $h == 17 ? 'selected' : '' }}>{{ sprintf('%02d:00', $h) }} WIB</option>
                                        @endfor
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1">Status Kehadiran</label>
                            <div class="relative">
                                <select id="statusKehadiran" name="status" class="w-full appearance-none rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-50 dark:bg-gray-700 px-4 py-3.5 text-sm font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <div id="buktiIzinContainer" class="space-y-2 hidden animate-in fade-in slide-in-from-top-2 duration-300">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1">Bukti Izin / Surat Sakit</label>
                            <div class="relative group">
                                <input type="file" id="photo-upload" class="hidden" accept="image/*,application/pdf">
                                <label for="photo-upload" class="flex flex-col items-center justify-center w-full py-8 border-2 border-dashed border-slate-200 dark:border-gray-600 rounded-2xl bg-slate-50 dark:bg-gray-700/30 hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer">
                                    <div class="h-12 w-12 flex items-center justify-center rounded-full bg-white dark:bg-gray-700 text-primary shadow-sm mb-3">
                                        <span class="material-symbols-outlined text-2xl">upload_file</span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200">Unggah Bukti</p>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase">Format: JPG, PNG, atau PDF</p>
                                </label>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </main>

        <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-t border-slate-100 dark:border-gray-700 p-4 pb-8">
            <div class="max-w-2xl mx-auto">
                <button type="submit" class="w-full flex items-center justify-center gap-3 rounded-2xl bg-primary py-4 text-sm font-bold text-white shadow-lg shadow-primary/30 hover:bg-blue-600 active:scale-[0.98] transition-all">
                    <span>Kirim Presensi</span>
                    <span class="material-symbols-outlined text-lg">send</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('statusKehadiran');
            const buktiContainer = document.getElementById('buktiIzinContainer');

            function toggleBukti() {
                const value = statusSelect.value;
                if (value === 'Izin' || value === 'Sakit') {
                    buktiContainer.classList.remove('hidden');
                } else {
                    buktiContainer.classList.add('hidden');
                }
            }

            // Jalankan saat ada perubahan
            statusSelect.addEventListener('change', toggleBukti);

            // Jalankan saat halaman pertama dimuat (antisipasi jika ada old value)
            toggleBukti();
        });
    </script>
@endsection
