@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Input Jurnal Harian - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Isi Jurnal Harian',
        'backUrl' => url('/siswa/jurnal_harian')
    ])

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">

        <main class="flex-1 p-5 sm:p-8 pb-36">
            <div class="max-w-2xl mx-auto">
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 space-y-6">

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1">Tanggal Kegiatan</label>
                            <div class="relative">
                                <input type="text"
                                       value="{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}"
                                       readonly
                                       class="w-full rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-100 dark:bg-gray-700/50 px-4 py-3.5 text-sm font-semibold text-slate-500 dark:text-slate-300 outline-none cursor-not-allowed">
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_today</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase ml-1">Rincian Kegiatan</label>
                            <textarea rows="6"
                                      class="w-full rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-50 dark:bg-gray-700 px-4 py-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white resize-none"
                                      placeholder="Deskripsikan pekerjaan atau materi yang Anda pelajari hari ini secara detail..."></textarea>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between ml-1">
                                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Foto Dokumentasi</label>
                                <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full uppercase">Opsional</span>
                            </div>
                            <div class="relative group">
                                <input type="file" id="doc-upload" class="hidden" accept="image/*">
                                <label for="doc-upload" class="flex flex-col items-center justify-center w-full py-10 border-2 border-dashed border-slate-200 dark:border-gray-600 rounded-2xl bg-slate-50 dark:bg-gray-700/30 hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer">
                                    <div class="h-14 w-14 flex items-center justify-center rounded-full bg-white dark:bg-gray-700 text-primary shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-3xl">add_a_photo</span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200">Unggah Foto Kegiatan</p>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-tight">Tap untuk mengambil foto atau pilih file</p>
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
                    <span>Simpan Jurnal Harian</span>
                    <span class="material-symbols-outlined text-lg">save</span>
                </button>
            </div>
        </div>
    </div>
@endsection
