@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Form Pengajuan PKL - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Pengajuan PKL',
        'backUrl' => url('/pengajuan')
    ])

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">

        <div class="px-6 py-8 bg-white dark:bg-gray-800 border-b border-slate-100 dark:border-gray-700">
            <div class="relative flex items-center justify-between max-w-xs mx-auto">
                <div class="absolute left-0 top-4 h-0.5 w-full -translate-y-1/2 bg-slate-200 dark:bg-gray-700"></div>

                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-primary/30">
                        <span class="text-xs font-bold">1</span>
                    </div>
                    <span class="text-[10px] font-bold text-primary uppercase tracking-wider">Pengajuan</span>
                </div>

                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white dark:bg-gray-700 border-2 border-slate-200 dark:border-gray-600 text-slate-400">
                        <span class="text-xs font-bold">2</span>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Proses</span>
                </div>

                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white dark:bg-gray-700 border-2 border-slate-200 dark:border-gray-600 text-slate-400">
                        <span class="text-xs font-bold">3</span>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Hasil</span>
                </div>
            </div>
        </div>

        <main class="flex-1 p-4 sm:p-6 pb-36">
            <div class="max-w-2xl mx-auto">
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 space-y-8">

                        <div class="space-y-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-primary text-xl">person</span>
                                <h3 class="text-slate-900 dark:text-white font-bold text-base">Data Diri</h3>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                                    <input type="text" value="Dimas Adrian" readonly
                                           class="w-full rounded-2xl border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900/50 px-4 py-3.5 text-sm font-semibold text-slate-500 dark:text-slate-400 outline-none cursor-not-allowed">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kelas / Jurusan</label>
                                    <input type="text" value="XII RPL 2" readonly
                                           class="w-full rounded-2xl border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900/50 px-4 py-3.5 text-sm font-semibold text-slate-500 dark:text-slate-400 outline-none cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-primary text-xl">domain</span>
                                <h3 class="text-slate-900 dark:text-white font-bold text-base">Pilih Industri</h3>
                            </div>
                            <div class="relative">
                                <select class="w-full appearance-none rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-50 dark:bg-gray-700 px-4 py-3.5 text-sm font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    <option disabled selected value="">Pilih mitra industri...</option>
                                    <option value="1">PT. Teknologi Nusantara</option>
                                    <option value="2">CV. Media Kreatif</option>
                                    <option value="3">Digital Agency Pekanbaru</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-primary text-xl">upload_file</span>
                                <h3 class="text-slate-900 dark:text-white font-bold text-base">Unggah Berkas (CV)</h3>
                            </div>
                            <div class="relative group">
                                <input type="file" id="cv-upload" class="hidden" accept=".pdf">
                                <label for="cv-upload" class="flex flex-col items-center justify-center w-full py-10 border-2 border-dashed border-slate-200 dark:border-gray-600 rounded-3xl bg-slate-50 dark:bg-gray-700/30 hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer">
                                    <div class="h-16 w-16 flex items-center justify-center rounded-2xl bg-white dark:bg-gray-700 text-primary shadow-sm mb-4 group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-4xl">cloud_upload</span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200">Klik untuk Pilih File</p>
                                    <p class="text-[10px] text-slate-400 mt-2 uppercase tracking-tight">Format: PDF (Maksimal 2MB)</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-t border-slate-100 dark:border-gray-700 p-4 pb-8 sm:rounded-b-[2.5rem]">
            <div class="max-w-2xl mx-auto">
                <button type="submit" class="w-full flex items-center justify-center gap-3 rounded-2xl bg-primary py-4 text-sm font-bold text-white shadow-lg shadow-primary/30 hover:bg-blue-600 active:scale-[0.98] transition-all">
                    <span>Kirim Pengajuan</span>
                    <span class="material-symbols-outlined text-lg">send</span>
                </button>
            </div>
        </div>
    </div>
@endsection
