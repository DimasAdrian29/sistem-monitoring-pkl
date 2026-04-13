@extends('layouts.siswa')

@section('title', 'Dashboard Siswa - SMKN 5 Pekanbaru')

@section('content')
    <div class="p-4 sm:p-6">
        {{-- Card Header Dinamis --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-blue-700 p-6 sm:p-8 shadow-lg">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

            <div class="relative">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-xs font-medium text-white">Status: {{ $pkl->status_magang }} Magang</span>
                </div>

                <h1 class="text-white text-2xl sm:text-3xl font-bold tracking-tight">Halo, {{ $siswa->nama }}</h1>
                <p class="text-blue-100 text-sm sm:text-base mt-1 opacity-90">{{ $siswa->kelas }} • {{ $siswa->jurusan }}</p>

                <div class="mt-6 flex items-center gap-3 text-white">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                        <span class="material-symbols-outlined">business_center</span>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider opacity-70">Lokasi Penempatan</p>
                        <p class="text-sm font-semibold">{{ $pkl->industri->nama }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 sm:px-6 pb-6">
        <h3 class="mb-4 text-lg font-bold flex items-center gap-2">
            <span class="h-5 w-1 bg-primary rounded-full"></span>
            Aktivitas Cepat
        </h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <a href="{{ url('/siswa/absensi') }}" class="group flex flex-col items-start gap-3 rounded-2xl bg-white dark:bg-gray-700/50 p-4 transition-all hover:ring-2 hover:ring-primary/20 border border-slate-100 dark:border-gray-700 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 dark:bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-2xl">location_on</span>
                </div>
                <div class="text-left">
                    <h2 class="text-sm font-bold">Isi Absensi</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-[11px] mt-1 leading-tight">Catat kehadiran harian lokasi PKL</p>
                </div>
            </a>

            <a href="{{ url('/siswa/jurnal_harian') }}" class="group flex flex-col items-start gap-3 rounded-2xl bg-white dark:bg-gray-700/50 p-4 transition-all hover:ring-2 hover:ring-primary/20 border border-slate-100 dark:border-gray-700 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 dark:bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-2xl">book_2</span>
                </div>
                <div class="text-left">
                    <h2 class="text-sm font-bold">Jurnal Harian</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-[11px] mt-1 leading-tight">Laporan kegiatan kerja harian</p>
                </div>
            </a>

            <a href="{{ url('/siswa/forum_diskusi') }}" class="group flex flex-col items-start gap-3 rounded-2xl bg-white dark:bg-gray-700/50 p-4 transition-all hover:ring-2 hover:ring-primary/20 border border-slate-100 dark:border-gray-700 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 dark:bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-2xl">forum</span>
                </div>
                <div class="text-left">
                    <h2 class="text-sm font-bold">Forum Diskusi</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-[11px] mt-1 leading-tight">Konsultasi dengan pembimbing</p>
                </div>
            </a>
            <a href="{{ url('/siswa/nilai') }}" class="group flex flex-col items-start gap-3 rounded-2xl bg-white dark:bg-gray-700/50 p-4 transition-all hover:ring-2 hover:ring-primary/20 border border-slate-100 dark:border-gray-700 shadow-sm">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 dark:bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-2xl">workspace_premium</span>
                </div>
                <div class="text-left">
                    <h2 class="text-sm font-bold">Lihat Nilai</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-[11px] mt-1 leading-tight">Cek hasil evaluasi magang</p>
                </div>
            </a>


        </div>
    </div>

    <div class="px-4 sm:px-6 mb-10">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold flex items-center gap-2">
                <span class="h-5 w-1 bg-green-500 rounded-full"></span>
                Aktivitas 7 Hari Terakhir
            </h3>

        </div>

        <div class="space-y-3">
            @forelse($activities as $activity)
                <div class="flex items-center gap-4 rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-slate-100 dark:border-gray-700 transition-all hover:border-primary/30">

                    @if($activity->activity_type == 'absensi')
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-50 dark:bg-green-900/20 text-green-600">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate text-slate-900 dark:text-white">Absensi {{ $activity->status_kehadiran }} Berhasil</p>
                            <p class="text-slate-500 dark:text-slate-400 text-xs truncate">
                                {{ \Carbon\Carbon::parse($activity->tanggal)->translatedFormat('l, d F Y') }} •
                                {{ $activity->jam_masuk ? substr($activity->jam_masuk, 0, 5) . ' WIB' : 'Waktu tidak tercatat' }}
                            </p>
                        </div>
                    @else
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                            <span class="material-symbols-outlined">edit_note</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate text-slate-900 dark:text-white">Mengisi Jurnal Harian</p>
                            <p class="text-slate-500 dark:text-slate-400 text-xs truncate">
                                {{ \Carbon\Carbon::parse($activity->tanggal)->translatedFormat('l, d F Y') }} • Status: {{ $activity->status_validasi }}
                            </p>
                        </div>
                    @endif

                    <span class="material-symbols-outlined text-slate-300">chevron_right</span>
                </div>
            @empty
                <div class="py-10 text-center bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-slate-100 dark:border-gray-700">
                    <p class="text-slate-400 text-sm">Belum ada aktivitas dalam 7 hari terakhir.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
