{{-- DYNAMIC LAYOUT: Cek role user --}}
@extends(Auth::user()->role === 'siswa' ? 'layouts.siswa' : 'layouts.pembimbing')

@section('title', 'Aktivitas PKL - SMKN 5 Pekanbaru')

@section('content')
    <div class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-slate-100 dark:border-gray-800">
        <div class="flex items-center justify-between p-4 max-w-lg mx-auto">
            <button onclick="history.back()" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 dark:bg-gray-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-gray-700 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </button>
            <h1 class="text-base font-bold text-slate-800 dark:text-white">Riwayat Aktivitas</h1>
            <div class="w-10"></div> {{-- Spacer --}}
        </div>
    </div>

    <main class="flex-1 w-full max-w-lg mx-auto p-4 flex flex-col gap-4 pb-32 bg-slate-50 dark:bg-gray-900 min-h-screen">

        <div class="flex items-center gap-2 px-1 mb-2">
            <span class="material-symbols-outlined text-primary text-xl">history</span>
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                {{ $role === 'siswa' ? 'Aktivitas Anda' : 'Aktivitas Siswa Bimbingan' }}
            </h3>
        </div>

        <div class="space-y-3">
            @forelse($activities as $activity)
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-slate-100 dark:border-gray-700 flex gap-4 transition-all hover:border-primary/30">

                    {{-- IKON BERDASARKAN TIPE AKTIVITAS --}}
                    @if($activity->type === 'absensi')
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                    @else
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                            <span class="material-symbols-outlined">book_2</span>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        {{-- Tampilkan Nama Siswa jika user adalah Pembimbing --}}
                        @if($role !== 'siswa')
                            <p class="text-[10px] font-bold text-primary uppercase tracking-wide mb-0.5 truncate">{{ $activity->siswa_nama }}</p>
                        @endif

                        <div class="flex items-start justify-between gap-2">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                {{ $activity->type === 'absensi' ? 'Absensi ' . $activity->status_kehadiran : 'Jurnal Harian' }}
                            </h4>
                            <span class="text-[10px] font-medium text-slate-400 whitespace-nowrap pt-0.5">
                                {{ \Carbon\Carbon::parse($activity->tanggal)->format('d M') }} • {{ $activity->jam }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">
                            {{ $activity->detail }}
                        </p>

                        {{-- BADGE STATUS VALIDASI --}}
                        <div class="mt-2 flex items-center gap-2">
                            @if($activity->status_validasi === 'Disetujui')
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-bold tracking-wide uppercase bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 border border-green-100 dark:border-green-800/50">Disetujui</span>
                            @elseif($activity->status_validasi === 'Menunggu')
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-bold tracking-wide uppercase bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-100 dark:border-amber-800/50">Menunggu</span>
                            @else
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-bold tracking-wide uppercase bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 border border-red-100 dark:border-red-800/50">Ditolak</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center p-10 bg-white dark:bg-gray-800 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm text-center mt-4">
                    <div class="w-16 h-16 bg-slate-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3 text-slate-300">
                        <span class="material-symbols-outlined text-3xl">inbox</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum Ada Aktivitas</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-[200px] mx-auto">
                        {{ $role === 'siswa' ? 'Anda belum melakukan absensi atau mengisi jurnal.' : 'Siswa bimbingan Anda belum melakukan aktivitas apapun.' }}
                    </p>
                </div>
            @endforelse
        </div>

    </main>
@endsection
