@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Input Jurnal Harian - SMKN 5 Pekanbaru')

@section('content')
    {{-- Header dengan tombol kembali --}}
    @include('siswa.partials.header_menu', [
        'title' => 'Isi Jurnal Harian',
        'backUrl' => url('/siswa/jurnal_harian')
    ])

    {{-- LOADING OVERLAY --}}
    <div id="loading-overlay" class="hidden fixed inset-0 z-[100] flex flex-col items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-md transition-all">
        <div class="relative flex items-center justify-center">
            <div class="h-20 w-20 border-4 border-slate-200 dark:border-gray-700 rounded-full"></div>
            <div class="absolute h-20 w-20 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            <span class="absolute material-symbols-outlined text-primary text-3xl animate-pulse">cloud_upload</span>
        </div>
        <p class="mt-6 text-sm font-bold text-slate-900 dark:text-white uppercase tracking-[0.2em] ml-1">Sedang Memproses</p>
        <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-2 uppercase font-medium">Mohon tunggu, sedang mengompres foto...</p>
    </div>

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">

        <main class="flex-1 p-5 sm:p-8 pb-36">
            <div class="max-w-2xl mx-auto">

                {{-- Menampilkan pesan error validasi umum jika ada --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30">
                        <ul class="list-disc list-inside text-xs text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="jurnalForm" action="{{ route('siswa.jurnal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 space-y-6">

                        {{-- Input Tanggal (Otomatis & Readonly) --}}
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1 tracking-wider">Tanggal Kegiatan</label>
                            <div class="relative">
                                <input type="text"
                                       value="{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}"
                                       readonly
                                       class="w-full rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-100 dark:bg-gray-700/50 px-4 py-3.5 text-sm font-semibold text-slate-500 dark:text-slate-300 outline-none cursor-not-allowed">
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_today</span>
                            </div>
                        </div>

                        {{-- Input Deskripsi Kegiatan --}}
                        <div class="space-y-2">
                            <label for="kegiatan" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1 tracking-wider">Rincian Kegiatan</label>
                            <textarea name="kegiatan" id="kegiatan" rows="6" required
                                      class="w-full rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-50 dark:bg-gray-700 px-4 py-3.5 text-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none dark:text-white resize-none @error('kegiatan') border-red-500 @enderror"
                                      placeholder="Contoh: Melakukan perbaikan jaringan lokal, instalasi sistem operasi, atau mempelajari konfigurasi router Mikrotik...">{{ old('kegiatan') }}</textarea>
                            @error('kegiatan')
                                <p class="text-[10px] text-red-500 font-bold ml-1 uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Foto Dokumentasi --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between ml-1">
                                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Foto Dokumentasi</label>
                                <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full uppercase">wajib</span>
                            </div>

                            <div class="relative group">
                                <input type="file" name="foto" id="doc-upload" class="hidden" accept="image/*" onchange="previewFileName(this)">
                                <label for="doc-upload" id="drop-area" class="flex flex-col items-center justify-center w-full py-10 border-2 border-dashed border-slate-200 dark:border-gray-600 rounded-2xl bg-slate-50 dark:bg-gray-700/30 hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer">
                                    <div id="icon-placeholder" class="h-14 w-14 flex items-center justify-center rounded-full bg-white dark:bg-gray-700 text-primary shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-3xl">add_a_photo</span>
                                    </div>
                                    <p id="file-name" class="text-sm font-bold text-slate-700 dark:text-slate-200 text-center px-4">Unggah Foto Kegiatan</p>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-tight">Tap untuk mengambil foto atau pilih file</p>
                                </label>
                            </div>
                            @error('foto')
                                <p class="text-[10px] text-red-500 font-bold ml-1 uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Tombol simpan yang menempel di bawah (Sticky) --}}
                    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-t border-slate-100 dark:border-gray-700 p-4 pb-8">
                        <div class="max-w-2xl mx-auto">
                            <button type="submit" id="submitBtn" class="w-full flex items-center justify-center gap-3 rounded-2xl bg-primary py-4 text-sm font-bold text-white shadow-lg shadow-primary/30 hover:bg-blue-600 active:scale-[0.98] transition-all">
                                <span id="btnText">Simpan Jurnal Harian</span>
                                <span id="btnIcon" class="material-symbols-outlined text-lg">save</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </main>

    </div>

    <script>
        const form = document.getElementById('jurnalForm');
        const overlay = document.getElementById('loading-overlay');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');

        /**
         * Logika saat form dikirim
         */
        form.addEventListener('submit', function() {
            // 1. Tampilkan overlay loading
            overlay.classList.remove('hidden');

            // 2. Ubah tampilan tombol
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            btnText.innerText = "Sedang Mengirim...";
            btnIcon.innerHTML = "sync";
            btnIcon.classList.add('animate-spin');
        });

        /**
         * Fungsi untuk memperbarui tampilan nama file setelah dipilih
         */
        function previewFileName(input) {
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const label = document.getElementById('file-name');
                const iconContainer = document.getElementById('icon-placeholder');
                const dropArea = document.getElementById('drop-area');

                label.innerText = "File: " + fileName;
                label.classList.add('text-primary');
                iconContainer.innerHTML = '<span class="material-symbols-outlined text-3xl text-green-500">check_circle</span>';
                dropArea.classList.add('border-primary/50', 'bg-primary/5');
            }
        }
    </script>
@endsection
