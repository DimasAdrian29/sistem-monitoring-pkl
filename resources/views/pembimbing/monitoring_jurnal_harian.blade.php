@extends('layouts.pembimbing')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Monitoring Jurnal',
        'backUrl' => url('/pembimbing'),
    ])

    <main class="flex-1 p-4 pt-6 bg-slate-50 dark:bg-gray-900 pb-32">
        <div class="mb-6 flex justify-center">
            <div
                class="flex items-center gap-3 rounded-full bg-white dark:bg-gray-800 px-6 py-3 shadow-sm border border-slate-200">
                <span class="material-symbols-outlined text-primary">calendar_month</span>
                <span class="text-sm font-bold">{{ $today->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 text-center">
                <p class="text-[10px] font-bold text-slate-500 uppercase">Total Jurnal</p>
                <p class="text-2xl font-bold text-primary">{{ $totalJurnal }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 text-center">
                <p class="text-[10px] font-bold text-slate-500 uppercase">Jurnal Hari Ini</p>
                <p class="text-2xl font-bold text-amber-500">{{ $jurnalBaru }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-slate-400 text-[11px] font-bold uppercase tracking-widest ml-1">Status Jurnal Siswa</h3>
            @foreach ($daftarPkl as $pkl)
                @php $jurnalToday = $pkl->logbooks->first(); @endphp
                <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-5 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-400">person</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $pkl->siswa->nama }}</p>
                            <p class="text-[11px] {{ $jurnalToday ? 'text-green-600' : 'text-red-500' }}">
                                {{ $jurnalToday ? 'Sudah mengisi jurnal' : 'Belum mengisi jurnal hari ini' }}
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="{{ url('/pembimbing/monitoring_jurnal_harian/detail/' . $pkl->id) }}"
                                class="p-2 bg-primary/10 text-primary rounded-xl">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
