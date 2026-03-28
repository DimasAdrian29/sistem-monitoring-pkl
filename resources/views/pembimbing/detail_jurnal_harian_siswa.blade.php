@extends('layouts.pembimbing', ['hideHeader' => true])

@section('title', 'Detail Jurnal Siswa - SMKN 5 Pekanbaru')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Monitoring Jurnal',
        'backUrl' => url('/pembimbing/monitoring_jurnal_harian')
    ])

    <main class="flex-1 overflow-y-auto no-scrollbar pb-24">

        <div class="bg-white dark:bg-gray-800 p-6 mb-2 border-b border-slate-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center gap-5">
                <div class="relative">
                    <div class="h-20 w-20 rounded-3xl bg-cover bg-center border-2 border-primary/20 shadow-inner"
                         style='background-image: url("https://i.pravatar.cc/150?u=4");'>
                    </div>
                    <span class="absolute -bottom-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-green-500 border-2 border-white dark:border-gray-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white truncate">Dimas Adrian</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-0.5 uppercase tracking-tighter">XII RPL 1 • Teknik Informatika</p>
                    <div class="mt-2 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-sm">business</span>
                        <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300">PT. Telkom Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 sticky top-0 z-20 bg-slate-50/90 dark:bg-gray-900/90 backdrop-blur-md">
            <div class="flex p-1 bg-slate-200/50 dark:bg-gray-800 rounded-2xl">
                <a href="{{ url('/pembimbing/detail_siswa') }}" class="flex-1 flex items-center justify-center py-2.5 rounded-xl text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-primary transition-all">
                    Absensi
                </a>
                <button class="flex-1 flex items-center justify-center py-2.5 rounded-xl bg-white dark:bg-gray-700 shadow-sm text-sm font-bold text-primary transition-all">
                    Jurnal Harian
                </button>
            </div>
        </div>

        <div class="px-4 flex flex-col gap-5">

            <div class="flex flex-col gap-4 bg-white dark:bg-gray-800 p-5 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">event_note</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Senin, 23 10 2023</h3>
                            <div class="flex items-center gap-1 text-[11px] text-slate-400 font-medium">
                                <span class="material-symbols-outlined text-xs">schedule</span>
                                <span>08:00 - 16:00 WIB</span>
                            </div>
                        </div>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-green-50 dark:bg-green-900/20 px-3 py-1 text-[10px] font-bold text-green-600 border border-green-100 dark:border-green-900/30 uppercase">Disetujui</span>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Rincian Kegiatan</p>
                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                        Melakukan konfigurasi VLAN pada switch distribusi di lantai 2 dan testing konektivitas antar departemen IT dan Marketing.
                    </p>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Dokumentasi</p>
                    <div class="h-40 w-full rounded-2xl bg-slate-100 dark:bg-gray-700 overflow-hidden border border-slate-200 dark:border-gray-600">
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=2068&auto=format&fit=crop" alt="Dokumentasi Kegiatan" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4 bg-white dark:bg-gray-800 p-5 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-900/10 flex items-center justify-center text-amber-600">
                            <span class="material-symbols-outlined">pending_actions</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Kamis, 19 10 2023</h3>
                            <div class="flex items-center gap-1 text-[11px] text-slate-400 font-medium">
                                <span class="material-symbols-outlined text-xs">schedule</span>
                                <span>08:15 - 17:00 WIB</span>
                            </div>
                        </div>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-amber-50 dark:bg-amber-900/20 px-3 py-1 text-[10px] font-bold text-amber-600 border border-amber-100 dark:border-amber-900/30 uppercase">Menunggu</span>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Rincian Kegiatan</p>
                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                        Mempelajari dokumentasi sistem ERP perusahaan dan shadowing teknisi senior dalam penanganan tiket support level 1.
                    </p>
                </div>

                <div class="mt-2 flex gap-2">
                    <button class="flex-1 py-3 rounded-xl bg-primary text-white text-xs font-bold shadow-lg shadow-primary/20 active:scale-95 transition-all">Setujui Jurnal</button>
                    <button class="px-4 py-3 rounded-xl bg-red-50 text-red-600 text-xs font-bold border border-red-100 active:scale-95 transition-all">Tolak</button>
                </div>
            </div>

        </div>

        <div class="h-10"></div>
    </main>
@endsection
