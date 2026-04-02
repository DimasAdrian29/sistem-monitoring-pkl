@extends('layouts.pembimbing')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Detail Jurnal',
        'backUrl' => url('/pembimbing/monitoring_jurnal_harian'),
    ])

    <main class="flex-1 p-4 pt-6 bg-slate-50 dark:bg-gray-900 pb-32">
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 mb-6 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold">{{ $pkl->siswa->nama }}</h2>
            <p class="text-xs text-slate-500 uppercase">{{ $pkl->siswa->kelas }} • {{ $pkl->siswa->jurusan }}</p>
        </div>

        <div class="space-y-6">
            @forelse($logbooks as $log)
                <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-6 border border-slate-100 shadow-sm relative">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs font-bold text-primary uppercase">
                                {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('l, d F Y') }}</p>
                            <span
                                class="text-[10px] px-2 py-0.5 rounded-full {{ $log->status_validasi == 'Disetujui' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $log->status_validasi }}
                            </span>
                        </div>
                    </div>

                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed italic mb-4">"{{ $log->kegiatan }}"
                    </p>

                    @if ($log->foto)
                        <img src="{{ asset('storage/' . $log->foto) }}"
                            class="w-full h-40 object-cover rounded-2xl mb-4 border border-slate-100">
                    @endif

                    @if ($log->status_validasi == 'Menunggu')
                        <form action="{{ url('/pembimbing/monitoring_jurnal_harian/approve/' . $log->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full py-3 bg-green-600 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-green-200">
                                Setujui Jurnal
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm">Belum ada riwayat jurnal.</p>
            @endforelse
        </div>
    </main>
@endsection
