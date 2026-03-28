@extends('layouts.pembimbing')

@section('title', 'Dashboard Pembimbing - SMKN 5 Pekanbaru')

@section('content')
    <div class="p-4 sm:p-6">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-slate-900 p-8 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="relative z-10">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Selamat Datang,</p>
                <h1 class="text-slate-900 dark:text-white text-2xl sm:text-3xl font-bold mt-1 leading-tight">
                    Pembimbing Industri <br> Bios Komputer
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-4">Hanung Wijaya</p>
            </div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-10 -mt-10 blur-3xl"></div>
        </div>
    </div>

    <div class="px-4 sm:px-6 grid grid-cols-2 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 mb-4">
                <span class="material-symbols-outlined">group</span>
            </div>
            <h2 class="text-2xl font-bold">1</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 font-medium tracking-wide uppercase">Siswa Bimbingan</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 mb-4">
                <span class="material-symbols-outlined">assignment_late</span>
            </div>
            <h2 class="text-2xl font-bold">2</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 font-medium tracking-wide uppercase">Izin Absensi</p>
        </div>
    </div>

    <div class="px-4 sm:px-6 space-y-4">
        <h3 class="text-slate-400 dark:text-slate-500 text-[11px] font-bold uppercase tracking-widest ml-1">Aksi Cepat</h3>

        <a href="{{ url('/pembimbing/monitoring_absensi') }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-50 dark:border-gray-700 shadow-sm transition-all hover:bg-slate-50 dark:hover:bg-gray-700/50 group">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 dark:bg-blue-900/20 text-primary">
                <span class="material-symbols-outlined text-[28px]">fact_check</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Monitoring Absensi</h4>
                <p class="text-slate-500 dark:text-slate-400 text-[11px]">Review daily attendance</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold animate-pulse">2</span>
                <span class="material-symbols-outlined text-slate-300 group-hover:translate-x-1 transition-transform">chevron_right</span>
            </div>
        </a>

        <a href="{{ url('/pembimbing/monitoring_jurnal_harian') }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-50 dark:border-gray-700 shadow-sm transition-all hover:bg-slate-50 dark:hover:bg-gray-700/50 group">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-50 dark:bg-gray-700 text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-[28px]">menu_book</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Monitoring Jurnal Harian</h4>
                <p class="text-slate-500 dark:text-slate-400 text-[11px]">Check student activities</p>
            </div>
            <span class="material-symbols-outlined text-slate-300 group-hover:translate-x-1 transition-transform">chevron_right</span>
        </a>

        <a href="{{ url('/pembimbing/input_nilai') }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-50 dark:border-gray-700 shadow-sm transition-all hover:bg-slate-50 dark:hover:bg-gray-700/50 group">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-50 dark:bg-gray-700 text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-[28px]">star</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Input Nilai</h4>
                <p class="text-slate-500 dark:text-slate-400 text-[11px]">Submit assessments</p>
            </div>
            <span class="material-symbols-outlined text-slate-300 group-hover:translate-x-1 transition-transform">chevron_right</span>
        </a>

        <a href="{{ url('/pembimbing/forum_diskusi') }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-50 dark:border-gray-700 shadow-sm transition-all hover:bg-slate-50 dark:hover:bg-gray-700/50 group">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-50 dark:bg-gray-700 text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-[28px]">forum</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Forum Diskusi</h4>
                <p class="text-slate-500 dark:text-slate-400 text-[11px]">Discuss with students</p>
            </div>
            <span class="material-symbols-outlined text-slate-300 group-hover:translate-x-1 transition-transform">chevron_right</span>
        </a>
    </div>
@endsection
