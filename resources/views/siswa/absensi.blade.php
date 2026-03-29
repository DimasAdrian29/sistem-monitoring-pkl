@extends('layouts.siswa')

@section('title', 'Absensi Siswa - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Absensi Siswa',
        'backUrl' => url('/siswa')
    ])

    <main class="flex flex-col gap-6 p-4 sm:p-6">

        {{-- TOMBOL ABSEN DINAMIS --}}
        <div class="grid grid-cols-1 gap-3">
            @if($sudahAbsen)
                <div class="relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-2xl bg-slate-100 dark:bg-gray-800 h-16 px-6 text-slate-400 border border-slate-200 dark:border-gray-700 cursor-not-allowed">
                    <span class="material-symbols-outlined">task_alt</span>
                    <span class="text-base font-bold tracking-wide">Absen Sudah Terisi</span>
                </div>
            @else
                <a href="{{ url('/siswa/absensi/form_absensi') }}" class="relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-2xl bg-green-600 h-16 px-6 text-white shadow-md active:scale-[0.98] transition-all hover:bg-green-700 group">
                    <span class="material-symbols-outlined group-hover:scale-110 transition-transform">check_circle</span>
                    <span class="text-base font-bold tracking-wide">Isi Absen</span>
                </a>
            @endif
        </div>

        {{-- KALENDER DINAMIS --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-6">
                <a href="{{ url('/siswa/absensi?month='.$prevMonth) }}" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-gray-700 text-slate-600 dark:text-slate-300 transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
                <div class="text-center">
                    <p class="text-slate-800 dark:text-white text-lg font-bold uppercase tracking-tight">{{ $monthName }}</p>
                    <p class="text-slate-400 text-xs">Informasi Kehadiran</p>
                </div>
                <a href="{{ url('/siswa/absensi?month='.$nextMonth) }}" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-gray-700 text-slate-600 dark:text-slate-300 transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </div>

            <div class="grid grid-cols-7 gap-y-2 mb-4 text-center">
                @foreach(['M', 'S', 'S', 'R', 'K', 'J', 'S'] as $day)
                    <div class="text-xs font-bold text-slate-400 uppercase py-2">{{ $day }}</div>
                @endforeach

                @for ($i = 1; $i <= $daysInMonth; $i++)
                    @php
                        $currentDayStr = $date->copy()->day($i)->format('Y-m-d');
                        $absenData = $absensi->get($currentDayStr);

                        $dotClass = '';
                        if($absenData) {
                            if($absenData->status_kehadiran == 'Hadir') $dotClass = 'bg-green-500';
                            elseif(in_array($absenData->status_kehadiran, ['Izin', 'Sakit'])) $dotClass = 'bg-amber-500';
                            elseif($absenData->status_kehadiran == 'Alpa') $dotClass = 'bg-red-500';
                        }

                        $isToday = $currentDayStr == date('Y-m-d');
                    @endphp

                    <div class="relative h-12 w-full flex flex-col items-center justify-center transition-all hover:bg-slate-50 dark:hover:bg-gray-700 rounded-xl cursor-pointer">
                        @if($isToday)
                            <div class="absolute inset-0 border-2 border-primary/20 rounded-xl"></div>
                        @endif

                        <span class="text-sm font-semibold {{ $isToday ? 'text-primary' : 'text-slate-700 dark:text-slate-200' }}">
                            {{ $i }}
                        </span>

                        @if($dotClass)
                            <div class="h-1.5 w-1.5 rounded-full {{ $dotClass }} mt-1"></div>
                        @endif
                    </div>
                @endfor
            </div>

            <div class="flex flex-wrap gap-4 pt-6 border-t border-slate-100 dark:border-gray-700 justify-center">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Hadir</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Alpha</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Izin/Sakit</span>
                </div>
            </div>
        </div>

        {{-- REKAPITULASI DINAMIS --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-green-50 dark:bg-green-900/10 p-4 rounded-2xl border border-green-100 dark:border-green-900/30 text-center">
                <p class="text-green-600 text-[10px] font-bold uppercase">Hadir</p>
                <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $rekap['Hadir'] }}</p>
            </div>
            <div class="bg-amber-50 dark:bg-amber-900/10 p-4 rounded-2xl border border-amber-100 dark:border-amber-900/30 text-center">
                <p class="text-amber-600 text-[10px] font-bold uppercase">Izin</p>
                <p class="text-2xl font-bold text-amber-700 dark:text-amber-400">{{ $rekap['Izin'] }}</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/10 p-4 rounded-2xl border border-red-100 dark:border-red-900/30 text-center">
                <p class="text-red-600 text-[10px] font-bold uppercase">Alpha</p>
                <p class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $rekap['Alpha'] }}</p>
            </div>
        </div>
    </main>
@endsection
