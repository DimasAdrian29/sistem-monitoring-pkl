@extends('layouts.siswa')

@section('title', 'Jurnal Harian - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Jurnal Harian',
        'backUrl' => url('/siswa')
    ])

    <main class="flex-1 overflow-y-auto no-scrollbar pb-24 px-4 sm:px-6 pt-6">

        <div class="mb-8">
            <a href="{{ url('/siswa/jurnal_harian/form_jurnal_harian') }}" class="w-full flex items-center justify-center gap-3 bg-primary hover:bg-blue-600 active:scale-[0.98] text-white rounded-2xl h-16 shadow-lg shadow-blue-500/20 transition-all duration-200 group">
                <span class="material-symbols-outlined text-[28px] group-hover:rotate-90 transition-transform duration-300">add_circle</span>
                <span class="text-base font-bold tracking-wide">Isi Jurnal Harian Hari Ini</span>
            </a>
        </div>

        <div class="flex items-center justify-between mb-4 px-1">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="h-5 w-1 bg-primary rounded-full"></span>
                Riwayat Jurnal
            </h3>
            <button class="text-sm font-semibold text-primary hover:bg-primary/5 px-3 py-1 rounded-lg transition-colors">Lihat Semua</button>
        </div>

        <div class="flex flex-col gap-4">

            <div class="group flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-primary/30 transition-all cursor-pointer">
                <div class="flex flex-col items-center justify-center shrink-0 w-14 h-14 bg-blue-50 dark:bg-primary/10 rounded-xl border border-blue-100 dark:border-primary/20">
                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest">MAR</span>
                    <span class="text-xl font-bold text-slate-900 dark:text-white leading-none">10</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate mb-0.5">Maintenance Server UNBK</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">Ruang Server • 08:00 - 16:00</p>
                </div>
                <div class="shrink-0">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-900/30">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-600 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-green-700 dark:text-green-400">Disetujui</span>
                    </div>
                </div>
            </div>

            <div class="group flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-primary/30 transition-all cursor-pointer">
                <div class="flex flex-col items-center justify-center shrink-0 w-14 h-14 bg-slate-50 dark:bg-gray-700 rounded-xl border border-slate-100 dark:border-gray-600">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">MAR</span>
                    <span class="text-xl font-bold text-slate-900 dark:text-white leading-none">09</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate mb-0.5">Konfigurasi Router Mikrotik</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">Lab Komputer • 09:00 - 15:00</p>
                </div>
                <div class="shrink-0">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-900/30">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                        <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400">Menunggu</span>
                    </div>
                </div>
            </div>

            <div class="group flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-primary/30 transition-all cursor-pointer">
                <div class="flex flex-col items-center justify-center shrink-0 w-14 h-14 bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/20">
                    <span class="text-[10px] font-bold text-red-500 uppercase tracking-widest">MAR</span>
                    <span class="text-xl font-bold text-slate-900 dark:text-white leading-none">08</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate mb-0.5">Instalasi OS Windows 11</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate uppercase font-medium">Laporan Kurang Detail</p>
                </div>
                <div class="shrink-0">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                        <span class="text-[10px] font-bold text-red-700 dark:text-red-400">Ditolak</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-8 p-4 rounded-2xl bg-blue-50 dark:bg-primary/5 border border-blue-100 dark:border-primary/10 flex gap-3">
            <span class="material-symbols-outlined text-primary">info</span>
            <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                Jurnal harian yang Anda isi akan diverifikasi oleh pembimbing lapangan. Pastikan deskripsi pekerjaan ditulis dengan jelas.
            </p>
        </div>
    </main>
@endsection
