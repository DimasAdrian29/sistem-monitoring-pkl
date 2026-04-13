@extends('layouts.pembimbing')

@section('title', 'Input Nilai Magang - SMKN 5 Pekanbaru')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Input Nilai Magang',
        'backUrl' => url('/pembimbing')
    ])

    <main class="flex-1 w-full max-w-lg mx-auto p-4 flex flex-col gap-4 bg-slate-50 dark:bg-gray-900">
        <div class="sticky top-0 z-40 bg-slate-50 dark:bg-gray-900 pb-2 pt-2">
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[22px]">search</span>
                </span>
                <input type="text" placeholder="Cari nama siswa atau kelas..." class="w-full py-4 pl-12 pr-4 text-sm text-slate-900 bg-white dark:bg-gray-800 border-0 ring-1 ring-slate-200 dark:ring-gray-700 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <h3 class="text-slate-400 text-[11px] font-bold uppercase tracking-widest ml-1">Daftar Siswa Bimbingan</h3>

            @forelse($pkls as $pkl)
                @php
                    // Cek apakah nilai sudah ada (berdasarkan role yang login)
                    $isIndustri = Auth::user()->hasRole('pembimbing_industri');
                    $sudahDinilai = false;

                    if($pkl->nilai) {
                        if($isIndustri && $pkl->nilai->aspek_soft_skills !== null) {
                            $sudahDinilai = true;
                        } elseif(!$isIndustri && $pkl->nilai->aspek_penyusunan_laporan !== null) {
                            $sudahDinilai = true;
                        }
                    }

                    // Inisial nama untuk avatar
                    $inisial = strtoupper(substr($pkl->siswa->nama, 0, 2));
                @endphp

                <a href="{{ url('/pembimbing/input_nilai/form_nilai/' . $pkl->id) }}" class="group bg-white dark:bg-gray-800 p-5 rounded-[2rem] shadow-sm border border-slate-100 dark:border-gray-700 flex items-center justify-between active:scale-[0.98] transition-all hover:border-primary/30">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-primary dark:text-blue-400 font-bold text-xl border-2 border-white dark:border-gray-600 shadow-sm relative">
                            {{ $inisial }}
                            @if($sudahDinilai)
                                <div class="absolute -bottom-1 -right-1 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 w-5 h-5 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-[12px] font-bold">check</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white text-base leading-tight group-hover:text-primary transition-colors">{{ $pkl->siswa->nama }}</h3>

                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $pkl->siswa->kelas ?? 'Kelas tidak diketahui' }} &bull; {{ $pkl->siswa->jurusan ?? 'Jurusan tidak diketahui' }}</p>

                            @if($sudahDinilai)
                                <span class="inline-flex items-center px-2 py-0.5 mt-2 text-[9px] font-bold tracking-wider uppercase text-green-700 bg-green-50 border border-green-100 rounded-md dark:bg-green-900/30 dark:text-green-400 dark:border-green-800">
                                    Sudah Dinilai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 mt-2 text-[9px] font-bold tracking-wider uppercase text-slate-500 bg-slate-100 border border-slate-200 rounded-md dark:bg-gray-700 dark:text-slate-400 dark:border-gray-600">
                                    Belum Dinilai
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="w-10 h-10 flex items-center justify-center rounded-xl transition-all {{ $sudahDinilai ? 'bg-slate-50 dark:bg-gray-700 text-slate-400 group-hover:bg-primary group-hover:text-white' : 'bg-primary text-white shadow-lg shadow-primary/20' }}">
                        <span class="material-symbols-outlined text-[20px]">{{ $sudahDinilai ? 'edit_square' : 'add_circle' }}</span>
                    </div>
                </a>
            @empty
                <div class="text-center p-8 text-slate-400 text-sm">
                    Belum ada data siswa bimbingan.
                </div>
            @endforelse

        </div>
    </main>
@endsection
