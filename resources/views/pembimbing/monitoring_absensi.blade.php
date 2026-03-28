@extends('layouts.pembimbing')

@section('title', 'Monitoring Absensi - SMKN 5 Pekanbaru')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Monitoring Absensi',
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
                <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Sudah Absen</p>
                <p class="text-2xl font-bold text-green-600">18</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 text-center shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Belum Absen</p>
                <p class="text-2xl font-bold text-red-500">2</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Daftar Siswa Bimbingan</h3>
                <span class="text-[10px] font-bold text-slate-400 px-2 py-0.5 rounded-full bg-slate-200/50 dark:bg-gray-700">20 Siswa</span>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-5 border border-slate-100 dark:border-gray-700 shadow-sm transition-all hover:border-primary/20">
                <div class="flex items-center gap-4">
                    <div class="relative h-14 w-14 shrink-0 overflow-hidden rounded-2xl border-2 border-slate-100 dark:border-gray-700 shadow-sm">
                        <div class="h-full w-full bg-cover bg-center" style='background-image: url("https://i.pravatar.cc/150?u=4");'></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-slate-900 dark:text-white text-base font-bold truncate">Dimas Adrian</p>
                        <div class="flex items-center gap-1.5 mt-1 text-green-600 dark:text-green-400 font-semibold">
                            <span class="material-symbols-outlined text-[16px]">schedule</span>
                            <p class="text-[11px]">07:30 WIB</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <span class="inline-flex items-center justify-center rounded-full bg-green-50 dark:bg-green-900/20 px-3 py-1 text-[10px] font-bold text-green-600 border border-green-100 dark:border-green-900/30">Hadir</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 dark:border-gray-700 flex justify-end">
                    <a href="{{ url('/pembimbing/monitoring_absensi/detail_siswa') }}" class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 dark:bg-gray-700 text-primary dark:text-blue-400 rounded-xl text-xs font-bold hover:bg-primary/5 transition-colors group">
                        <span>Lihat Detail</span>
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-5 border border-slate-100 dark:border-gray-700 shadow-sm transition-all hover:border-primary/20">
                <div class="flex items-center gap-4">
                    <div class="relative h-14 w-14 shrink-0 overflow-hidden rounded-2xl border-2 border-slate-100 dark:border-gray-700 shadow-sm">
                        <div class="h-full w-full bg-cover bg-center" style='background-image: url("https://i.pravatar.cc/150?u=5");'></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-slate-900 dark:text-white text-base font-bold truncate">Budi Santoso</p>
                        <div class="flex items-center gap-1.5 mt-1 text-slate-400 font-semibold">
                            <span class="material-symbols-outlined text-[16px]">schedule</span>
                            <p class="text-[11px]">-- : --</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <span class="inline-flex items-center justify-center rounded-full bg-red-50 dark:bg-red-900/20 px-3 py-1 text-[10px] font-bold text-red-500 border border-red-100 dark:border-red-900/30">Alpha</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 dark:border-gray-700 flex justify-end">
                    <a href="{{ url('/pembimbing/detail_siswa') }}" class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 dark:bg-gray-700 text-primary dark:text-blue-400 rounded-xl text-xs font-bold hover:bg-primary/5 transition-colors group">
                        <span>Lihat Detail</span>
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>

        </div>
    </main>
@endsection
