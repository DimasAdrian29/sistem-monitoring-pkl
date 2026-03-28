@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Informasi Mitra PKL - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Informasi Mitra Industri',
        'backUrl' => url('/pengajuan')
    ])

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">

        <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 border-b border-slate-100 dark:border-gray-700 sticky top-16 z-10 shadow-sm">
            <div class="max-w-4xl mx-auto space-y-4">
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" placeholder="Cari nama perusahaan atau lokasi..."
                           class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 text-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none dark:text-white">
                </div>

                <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                    <button class="px-4 py-2 rounded-full bg-primary text-white text-[11px] font-bold uppercase tracking-wider whitespace-nowrap shadow-md shadow-primary/20">Semua Jurusan</button>
                    <button class="px-4 py-2 rounded-full bg-white dark:bg-gray-700 text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-gray-600 text-[11px] font-bold uppercase tracking-wider whitespace-nowrap hover:bg-slate-50">Teknik Komputer</button>
                    <button class="px-4 py-2 rounded-full bg-white dark:bg-gray-700 text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-gray-600 text-[11px] font-bold uppercase tracking-wider whitespace-nowrap hover:bg-slate-50">Rekayasa Perangkat Lunak</button>
                    <button class="px-4 py-2 rounded-full bg-white dark:bg-gray-700 text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-gray-600 text-[11px] font-bold uppercase tracking-wider whitespace-nowrap hover:bg-slate-50">Multimedia</button>
                </div>
            </div>
        </div>

        <main class="flex-1 p-4 sm:p-6 pb-20">
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="group bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-blue-50 dark:bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">domain</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white truncate">PT. Teknologi Nusantara</h3>
                                <span class="px-2 py-0.5 rounded-md bg-green-100 dark:bg-green-900/30 text-green-600 text-[9px] font-extrabold uppercase tracking-tighter">Tersedia</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">location_on</span> Pekanbaru, Riau
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="text-[9px] font-bold px-2 py-1 bg-slate-100 dark:bg-gray-700 rounded-lg text-slate-600 dark:text-slate-300">Web Developer</span>
                                <span class="text-[9px] font-bold px-2 py-1 bg-slate-100 dark:bg-gray-700 rounded-lg text-slate-600 dark:text-slate-300">Networking</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-50 dark:border-gray-700 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400">Kuota: <span class="text-slate-900 dark:text-white">3 Siswa</span></span>
                        <a href="{{ url('/pengajuan/form_pengajuan?id=1') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                            Pilih Tempat <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <div class="group bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-amber-50 dark:bg-amber-900/10 flex items-center justify-center text-amber-600 shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">brush</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white truncate">CV. Media Kreatif</h3>
                                <span class="px-2 py-0.5 rounded-md bg-red-100 dark:bg-red-900/30 text-red-600 text-[9px] font-extrabold uppercase tracking-tighter">Penuh</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">location_on</span> Pekanbaru, Riau
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="text-[9px] font-bold px-2 py-1 bg-slate-100 dark:bg-gray-700 rounded-lg text-slate-600 dark:text-slate-300">Graphic Design</span>
                                <span class="text-[9px] font-bold px-2 py-1 bg-slate-100 dark:bg-gray-700 rounded-lg text-slate-600 dark:text-slate-300">Video Editor</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-50 dark:border-gray-700 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400">Kuota: <span class="text-slate-900 dark:text-white text-red-500">0 Siswa</span></span>
                        <span class="text-xs font-bold text-slate-300 cursor-not-allowed">Tidak Tersedia</span>
                    </div>
                </div>

            </div>
        </main>

        <div class="p-6 text-center">
            <p class="text-[10px] text-slate-400 uppercase tracking-widest leading-relaxed">
                Daftar mitra di atas adalah industri yang sudah memiliki MoU aktif dengan SMKN 5 Pekanbaru.
            </p>
        </div>
    </div>
@endsection
