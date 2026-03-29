@extends('layouts.siswa')

@section('title', 'Jurnal Harian - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Jurnal Harian',
        'backUrl' => url('/siswa')
    ])

    <main class="flex-1 overflow-y-auto no-scrollbar pb-24 px-4 sm:px-6 pt-6">

        {{-- TOMBOL ISI JURNAL DINAMIS --}}
        <div class="mb-8">
            @if($hasFilledToday)
                {{-- Tombol jika sudah mengisi --}}
                <div class="w-full flex items-center justify-center gap-3 bg-slate-100 dark:bg-gray-800 text-slate-400 rounded-2xl h-16 border border-slate-200 dark:border-gray-700 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[28px]">task_alt</span>
                    <span class="text-base font-bold tracking-wide">Sudah Mengisi Jurnal Hari Ini</span>
                </div>
            @else
                {{-- Tombol jika belum mengisi --}}
                <a href="{{ url('/siswa/jurnal_harian/form_jurnal_harian') }}"
                   class="w-full flex items-center justify-center gap-3 bg-primary hover:bg-blue-600 active:scale-[0.98] text-white rounded-2xl h-16 shadow-lg shadow-blue-500/20 transition-all duration-200 group">
                    <span class="material-symbols-outlined text-[28px] group-hover:rotate-90 transition-transform duration-300">add_circle</span>
                    <span class="text-base font-bold tracking-wide">Isi Jurnal Harian Hari Ini</span>
                </a>
            @endif
        </div>

        <div class="flex items-center justify-between mb-4 px-1">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="h-5 w-1 bg-primary rounded-full"></span>
                Riwayat Jurnal
            </h3>
        </div>

        <div class="flex flex-col gap-4">
            @forelse($logbooks as $log)
                @php
                    $tanggal = \Carbon\Carbon::parse($log->tanggal);
                    // Warna status
                    $statusClasses = [
                        'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-900/30',
                        'Disetujui' => 'bg-green-50 text-green-700 border-green-100 dark:bg-green-900/20 dark:text-green-400 dark:border-green-900/30',
                        'Ditolak' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-900/30',
                    ];
                    $dotClasses = [
                        'Menunggu' => 'bg-amber-600',
                        'Disetujui' => 'bg-green-600 animate-pulse',
                        'Ditolak' => 'bg-red-600',
                    ];
                @endphp

                <div class="group flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-primary/30 transition-all">
                    {{-- Kotak Tanggal --}}
                    <div class="flex flex-col items-center justify-center shrink-0 w-14 h-14 {{ $log->status_validasi == 'Ditolak' ? 'bg-red-50 dark:bg-red-900/10 border-red-100' : 'bg-blue-50 dark:bg-primary/10 border-blue-100' }} rounded-xl border">
                        <span class="text-[10px] font-bold {{ $log->status_validasi == 'Ditolak' ? 'text-red-500' : 'text-primary' }} uppercase tracking-widest">
                            {{ $tanggal->translatedFormat('M') }}
                        </span>
                        <span class="text-xl font-bold text-slate-900 dark:text-white leading-none">
                            {{ $tanggal->format('d') }}
                        </span>
                    </div>

                    {{-- Detail Kegiatan --}}
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate mb-0.5">
                            {{ $log->kegiatan }}
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                            {{ $log->status_validasi == 'Ditolak' ? 'Klik untuk lihat alasan penolakan' : 'Kegiatan PKL Terlaksana' }}
                        </p>
                    </div>

                    {{-- Badge Status --}}
                    <div class="shrink-0">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border {{ $statusClasses[$log->status_validasi] ?? '' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $dotClasses[$log->status_validasi] ?? 'bg-slate-400' }}"></span>
                            <span class="text-[10px] font-bold">{{ $log->status_validasi }}</span>
                        </div>
                    </div>
                </div>
            @empty
                {{-- State jika belum ada jurnal --}}
                <div class="text-center py-12">
                    <div class="h-20 w-20 bg-slate-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl text-slate-300">history_edu</span>
                    </div>
                    <p class="text-slate-500 text-sm">Belum ada riwayat jurnal harian.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 p-4 rounded-2xl bg-blue-50 dark:bg-primary/5 border border-blue-100 dark:border-primary/10 flex gap-3">
            <span class="material-symbols-outlined text-primary">info</span>
            <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                Jurnal harian yang Anda isi akan diverifikasi oleh pembimbing lapangan. Pastikan deskripsi pekerjaan ditulis dengan jelas.
            </p>
        </div>
    </main>
@endsection
