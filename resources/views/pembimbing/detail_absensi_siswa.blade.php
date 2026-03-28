@extends('layouts.pembimbing', ['hideHeader' => true])

@section('title', 'Detail Monitoring Siswa - SMKN 5 Pekanbaru')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Monitoring Siswa',
        'backUrl' => url('/pembimbing/monitoring_absensi')
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
                <button class="flex-1 flex items-center justify-center py-2.5 rounded-xl bg-white dark:bg-gray-700 shadow-sm text-sm font-bold text-primary transition-all">
                    Absensi
                </button>
                <button class="flex-1 flex items-center justify-center py-2.5 rounded-xl text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-primary transition-all">
                    Jurnal Harian
                </button>
            </div>
        </div>

        <div class="px-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-6 shadow-sm border border-slate-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <button class="p-2 rounded-full hover:bg-slate-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined text-slate-400">chevron_left</span>
                    </button>
                    <div class="text-center">
                        <h4 class="text-base font-bold text-slate-800 dark:text-white">Maret 2026</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Ringkasan Bulanan</p>
                    </div>
                    <button class="p-2 rounded-full hover:bg-slate-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                    </button>
                </div>

                <div class="grid grid-cols-7 text-center mb-2">
                    @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                        <span class="text-[10px] font-bold text-slate-300 uppercase py-2">{{ $day }}</span>
                    @endforeach

                    @for($i = 1; $i <= 31; $i++)
                        <div class="relative py-2 flex flex-col items-center group cursor-pointer">
                            <span class="text-sm font-semibold {{ $i == 10 ? 'text-white bg-primary rounded-full size-7 flex items-center justify-center shadow-md shadow-primary/30' : 'text-slate-700 dark:text-slate-300' }}">
                                {{ $i }}
                            </span>
                            @if(in_array($i, [2,3,4,5,9]))
                                <div class="size-1 rounded-full bg-green-500 mt-1"></div>
                            @elseif($i == 8)
                                <div class="size-1 rounded-full bg-amber-500 mt-1"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="px-4 space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Detail Kehadiran</h3>
                <span class="text-[10px] font-bold text-primary uppercase tracking-tighter">Lihat Semua</span>
            </div>

            <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm">
                <div class="h-12 w-12 rounded-2xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-600 shrink-0">
                    <span class="material-symbols-outlined filled">check_circle</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">Selasa, 10 03 2026</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mt-0.5">Masuk: 07:45 • Keluar: 17:00</p>
                </div>
                <div class="shrink-0">
                    <span class="px-2.5 py-1 rounded-lg bg-green-50 dark:bg-green-900/30 text-[10px] font-extrabold text-green-600 uppercase">Hadir</span>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm">
                <div class="h-12 w-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600 shrink-0">
                    <span class="material-symbols-outlined">medication</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">Senin, 09 03 2026</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mt-0.5">Keterangan: Demam / Sakit</p>
                </div>
                <div class="shrink-0">
                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-[10px] font-extrabold text-amber-600 uppercase tracking-tighter">Sakit</span>
                </div>
            </div>

        </div>

    </main>
@endsection
