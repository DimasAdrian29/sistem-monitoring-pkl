@extends('layouts.pembimbing')

@section('title', 'Monitoring Jurnal Harian - SMKN 5 Pekanbaru')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Monitoring Jurnal Harian',
        'backUrl' => url('/pembimbing')
    ])

    <main class="flex-1 overflow-y-auto no-scrollbar pb-32 px-4 pt-6 bg-slate-50 dark:bg-gray-900">

        <div class="mb-6 flex justify-center">
            <button class="group flex items-center gap-3 rounded-full bg-white dark:bg-gray-800 px-6 py-3 shadow-sm border border-slate-200 dark:border-gray-700 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-primary text-xl">calendar_month</span>
                <span class="text-slate-900 dark:text-white text-sm font-bold tracking-wider">
                    {{ \Carbon\Carbon::now()->format('d m Y') }}
                </span>
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors text-xl">arrow_drop_down</span>
            </button>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 text-center shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Total Jurnal</p>
                <p class="text-2xl font-bold text-primary">45</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 text-center shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Jurnal Baru</p>
                <p class="text-2xl font-bold text-amber-500">5</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Daftar Jurnal Siswa</h3>
                <span class="text-[10px] font-bold text-slate-400 px-2 py-0.5 rounded-full bg-slate-200/50 dark:bg-gray-700">20 Entri</span>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-5 border border-slate-100 dark:border-gray-700 shadow-sm transition-all hover:border-primary/20">
                <div class="flex items-center gap-4">
                    <div class="relative h-14 w-14 shrink-0 overflow-hidden rounded-2xl border-2 border-slate-100 dark:border-gray-700">
                        <div class="h-full w-full bg-cover bg-center" style='background-image: url("https://i.pravatar.cc/150?u=4");'></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-slate-900 dark:text-white text-base font-bold truncate">Dimas Adrian</p>
                        <div class="flex items-center gap-1.5 mt-1 text-slate-500 dark:text-slate-400">
                            <span class="material-symbols-outlined text-[16px]">edit_note</span>
                            <p class="text-[11px] font-medium truncate italic">"Instalasi Server Debian..."</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <span class="inline-flex items-center justify-center rounded-full bg-green-50 dark:bg-green-900/20 px-3 py-1 text-[10px] font-bold text-green-600 border border-green-100 dark:border-green-900/30">Disetujui</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 dark:border-gray-700 flex justify-end">
                    <a href="{{ url('/pembimbing/monitoring_jurnal_harian/detail') }}" class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 dark:bg-gray-700 text-primary dark:text-blue-400 rounded-xl text-xs font-bold hover:bg-primary/5 transition-colors group">
                        <span>Lihat Detail</span>
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-5 border border-slate-100 dark:border-gray-700 shadow-sm transition-all hover:border-primary/20">
                <div class="flex items-center gap-4">
                    <div class="relative h-14 w-14 shrink-0 overflow-hidden rounded-2xl border-2 border-slate-100 dark:border-gray-700">
                        <div class="h-full w-full bg-cover bg-center" style='background-image: url("https://i.pravatar.cc/150?u=5");'></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-slate-900 dark:text-white text-base font-bold truncate">Budi Santoso</p>
                        <div class="flex items-center gap-1.5 mt-1 text-slate-500 dark:text-slate-400">
                            <span class="material-symbols-outlined text-[16px]">edit_note</span>
                            <p class="text-[11px] font-medium truncate italic">"Konfigurasi Mikrotik..."</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <span class="inline-flex items-center justify-center rounded-full bg-amber-50 dark:bg-amber-900/20 px-3 py-1 text-[10px] font-bold text-amber-600 border border-amber-100 dark:border-amber-900/30">Pending</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 dark:border-gray-700 flex justify-end">
                    <a href="{{ url('/pembimbing/detail_siswa') }}" class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 dark:bg-gray-700 text-primary dark:text-blue-400 rounded-xl text-xs font-bold hover:bg-primary/5 transition-colors group">
                        <span>Review Jurnal</span>
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>

        </div>
    </main>
@endsection
