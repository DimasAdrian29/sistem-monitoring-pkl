@extends('layouts.siswa')

@section('title', 'Nilai PKL Siswa - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Hasil Penilaian PKL',
        'backUrl' => url('/siswa'),
    ])

    <main class="flex flex-col gap-6 p-4 sm:p-6 pb-24">

        @if (!$pkl || !$pkl->nilai)
            {{-- KONDISI BELUM ADA NILAI SAMA SEKALI --}}
            <div
                class="flex flex-col items-center justify-center p-10 bg-white dark:bg-gray-800 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm text-center">
                <div
                    class="w-20 h-20 bg-slate-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-slate-300">
                    <span class="material-symbols-outlined text-4xl">hourglass_empty</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Nilai Belum Tersedia</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 max-w-xs">
                    Pembimbing Industri atau Guru Pembimbing Anda belum menginputkan nilai untuk kegiatan PKL ini.
                </p>
            </div>
        @else
            {{-- KONDISI SUDAH ADA NILAI --}}

            {{-- HEADER RATA-RATA --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-primary to-blue-700 rounded-[2rem] p-6 shadow-lg shadow-primary/20 border border-white/10 text-white">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative flex items-center justify-between z-10">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest opacity-80">Rata-rata Nilai Akhir</p>
                        <p class="text-sm mt-1 font-medium opacity-90">{{ $pkl->industri->nama }}</p>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-black tracking-tighter">{{ $rataRata }}</span>
                        <span class="text-sm font-bold opacity-60">/ 100</span>
                    </div>
                </div>
            </div>

            {{-- NILAI INDUSTRI --}}
            <div class="space-y-3">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-primary text-xl">factory</span>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Penilaian
                        Industri</h3>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-[2rem] border border-slate-100 dark:border-gray-700 overflow-hidden shadow-sm">
                    <div class="divide-y divide-slate-50 dark:divide-gray-700">
                        <div class="flex items-center justify-between p-5">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Soft Skills Dunia
                                Kerja</span>
                            <span
                                class="text-lg font-black {{ $pkl->nilai->aspek_soft_skills ? 'text-primary' : 'text-slate-300' }}">{{ $pkl->nilai->aspek_soft_skills ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-5">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Norma, POS & K3LH</span>
                            <span
                                class="text-lg font-black {{ $pkl->nilai->aspek_norma_k3lh ? 'text-primary' : 'text-slate-300' }}">{{ $pkl->nilai->aspek_norma_k3lh ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-5">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kompetensi Teknis</span>
                            <span
                                class="text-lg font-black {{ $pkl->nilai->aspek_kompetensi_teknis ? 'text-primary' : 'text-slate-300' }}">{{ $pkl->nilai->aspek_kompetensi_teknis ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-5">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Wawasan Bisnis</span>
                            <span
                                class="text-lg font-black {{ $pkl->nilai->aspek_wawasan_bisnis ? 'text-primary' : 'text-slate-300' }}">{{ $pkl->nilai->aspek_wawasan_bisnis ?? '-' }}</span>
                        </div>
                    </div>

                    @if ($pkl->nilai->catatan_pembimbing_industri)
                        <div class="p-5 bg-slate-50 dark:bg-gray-800/50 border-t border-slate-100 dark:border-gray-700">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Pembimbing
                                Industri ({{ $pkl->pembimbing_industri->nama ?? 'N/A' }})</p>
                            <p class="text-sm text-slate-600 dark:text-slate-300 italic">
                                "{{ $pkl->nilai->catatan_pembimbing_industri }}"</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- NILAI SEKOLAH --}}
            <div class="space-y-3">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-primary text-xl">school</span>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Penilaian
                        Sekolah</h3>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-[2rem] border border-slate-100 dark:border-gray-700 overflow-hidden shadow-sm">
                    <div class="divide-y divide-slate-50 dark:divide-gray-700">
                        <div class="flex items-center justify-between p-5">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penyusunan Laporan
                                PKL</span>
                            <span
                                class="text-lg font-black {{ $pkl->nilai->aspek_penyusunan_laporan ? 'text-primary' : 'text-slate-300' }}">{{ $pkl->nilai->aspek_penyusunan_laporan ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-5">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Presentasi Hasil
                                PKL</span>
                            <span
                                class="text-lg font-black {{ $pkl->nilai->aspek_presentasi ? 'text-primary' : 'text-slate-300' }}">{{ $pkl->nilai->aspek_presentasi ?? '-' }}</span>
                        </div>
                    </div>

                    @if ($pkl->nilai->catatan_guru_pembimbing)
                        <div class="p-5 bg-slate-50 dark:bg-gray-800/50 border-t border-slate-100 dark:border-gray-700">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Guru
                                Pembimbing ({{ $pkl->guru_pembimbing->nama ?? 'N/A' }})</p>
                            <p class="text-sm text-slate-600 dark:text-slate-300 italic">
                                "{{ $pkl->nilai->catatan_guru_pembimbing }}"</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- SECTION SERTIFIKAT --}}
            <div class="space-y-3">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-primary text-xl">workspace_premium</span>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sertifikat
                        PKL</h3>
                </div>

                @if ($pkl->sertifikat && $pkl->sertifikat->url_sertifikat)
                    {{-- Sertifikat sudah tersedia --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-[2rem] border border-slate-100 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div class="p-5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-green-500 text-xl">verified</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 dark:text-white">Sertifikat Tersedia</p>
                                    <p class="text-xs text-slate-400">Dicetak pada
                                        {{ $pkl->sertifikat->dicetak_pada->isoFormat('D MMMM Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($pkl->sertifikat->url_sertifikat) }}" target="_blank"
                                class="flex items-center gap-1 bg-primary text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-blue-700 transition">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Download
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Sertifikat belum dirilis --}}
                    <div
                        class="flex flex-col items-center justify-center p-8 bg-white dark:bg-gray-800 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm text-center">
                        <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-amber-400 text-3xl">pending</span>
                        </div>
                        <p class="text-sm font-bold text-slate-700 dark:text-white">Sertifikat Belum Dirilis</p>
                        <p class="text-xs text-slate-400 mt-1">Sertifikat akan tersedia setelah admin memprosesnya.</p>
                    </div>
                @endif
            </div>

        @endif
    </main>
@endsection
