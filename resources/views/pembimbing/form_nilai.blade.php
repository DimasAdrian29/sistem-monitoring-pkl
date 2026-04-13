@extends('layouts.pembimbing', ['hideNav' => true])

@section('title', 'Form Penilaian Siswa - SMKN 5 Pekanbaru')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Input Nilai Magang',
        'backUrl' => url('/pembimbing/input_nilai')
    ])

    <main class="flex-1 w-full max-w-lg mx-auto p-4 flex flex-col gap-6 pb-32 bg-slate-50 dark:bg-gray-900">

        <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm p-5 flex items-center gap-4 border border-slate-100 dark:border-gray-700">
            <div class="relative shrink-0">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-bold text-xl border-2 border-primary/20">
                    {{ strtoupper(substr($pkl->siswa->nama, 0, 2)) }}
                </div>
            </div>
            <div class="flex flex-col flex-1 min-w-0">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white leading-tight truncate">{{ $pkl->siswa->nama }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-blue-50 text-primary dark:bg-primary/10 tracking-wide uppercase">{{ $pkl->siswa->kelas ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('pembimbing.nilai.store', $pkl->id) }}" method="POST" class="space-y-6">
            @csrf

            @if($role === 'industri')
            <div class="space-y-3">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-primary text-xl">factory</span>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Penilaian Industri</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-[2rem] border border-slate-100 dark:border-gray-700 overflow-hidden divide-y divide-slate-50 dark:divide-gray-700 shadow-sm">

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Soft Skills Dunia Kerja</label>
                            <span class="text-xl font-black text-primary tabular-nums val-display" id="val-soft-skills">{{ $nilai->aspek_soft_skills ?? 0 }}</span>
                        </div>
                        <input type="range" name="aspek_soft_skills" min="0" max="100" value="{{ $nilai->aspek_soft_skills ?? 0 }}" class="input-nilai w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer" oninput="updateNilai('val-soft-skills', this.value)">
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Norma, POS & K3LH</label>
                            <span class="text-xl font-black text-primary tabular-nums val-display" id="val-k3lh">{{ $nilai->aspek_norma_k3lh ?? 0 }}</span>
                        </div>
                        <input type="range" name="aspek_norma_k3lh" min="0" max="100" value="{{ $nilai->aspek_norma_k3lh ?? 0 }}" class="input-nilai w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer" oninput="updateNilai('val-k3lh', this.value)">
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Kompetensi Teknis</label>
                            <span class="text-xl font-black text-primary tabular-nums val-display" id="val-teknis">{{ $nilai->aspek_kompetensi_teknis ?? 0 }}</span>
                        </div>
                        <input type="range" name="aspek_kompetensi_teknis" min="0" max="100" value="{{ $nilai->aspek_kompetensi_teknis ?? 0 }}" class="input-nilai w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer" oninput="updateNilai('val-teknis', this.value)">
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Wawasan Bisnis</label>
                            <span class="text-xl font-black text-primary tabular-nums val-display" id="val-bisnis">{{ $nilai->aspek_wawasan_bisnis ?? 0 }}</span>
                        </div>
                        <input type="range" name="aspek_wawasan_bisnis" min="0" max="100" value="{{ $nilai->aspek_wawasan_bisnis ?? 0 }}" class="input-nilai w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer" oninput="updateNilai('val-bisnis', this.value)">
                    </div>

                    <div class="p-6 bg-slate-50 dark:bg-gray-800/50">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Catatan Pembimbing Industri</label>
                        <textarea name="catatan_pembimbing_industri" rows="3" class="w-full rounded-xl border border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 p-3 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="Masukkan catatan untuk siswa...">{{ $nilai->catatan_pembimbing_industri }}</textarea>
                    </div>
                </div>
            </div>
            @endif

            @if($role === 'guru')
            <div class="space-y-3">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-primary text-xl">school</span>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Penilaian Sekolah</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-[2rem] border border-slate-100 dark:border-gray-700 overflow-hidden divide-y divide-slate-50 dark:divide-gray-700 shadow-sm">

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Penyusunan Laporan PKL</label>
                            <span class="text-xl font-black text-primary tabular-nums val-display" id="val-laporan">{{ $nilai->aspek_penyusunan_laporan ?? 0 }}</span>
                        </div>
                        <input type="range" name="aspek_penyusunan_laporan" min="0" max="100" value="{{ $nilai->aspek_penyusunan_laporan ?? 0 }}" class="input-nilai w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer" oninput="updateNilai('val-laporan', this.value)">
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Presentasi Hasil PKL</label>
                            <span class="text-xl font-black text-primary tabular-nums val-display" id="val-presentasi">{{ $nilai->aspek_presentasi ?? 0 }}</span>
                        </div>
                        <input type="range" name="aspek_presentasi" min="0" max="100" value="{{ $nilai->aspek_presentasi ?? 0 }}" class="input-nilai w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer" oninput="updateNilai('val-presentasi', this.value)">
                    </div>

                    <div class="p-6 bg-slate-50 dark:bg-gray-800/50">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Catatan Guru Pembimbing</label>
                        <textarea name="catatan_guru_pembimbing" rows="3" class="w-full rounded-xl border border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-700 p-3 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="Masukkan evaluasi laporan dan presentasi...">{{ $nilai->catatan_guru_pembimbing }}</textarea>
                    </div>
                </div>
            </div>
            @endif

            <div class="relative overflow-hidden bg-gradient-to-br from-primary to-blue-700 rounded-[2rem] p-6 shadow-lg shadow-primary/20 border border-white/10 text-white mt-6">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative flex items-center justify-between z-10">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest opacity-80">Rata-rata Nilai Anda</p>
                        <p class="text-xs mt-1 opacity-70 italic">Kalkulasi Otomatis</p>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-black tracking-tighter" id="rata-rata-display">0</span>
                        <span class="text-sm font-bold opacity-60">/ 100</span>
                    </div>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 right-0 p-4 pb-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-t border-slate-100 dark:border-gray-700 z-50">
                <div class="max-w-lg mx-auto">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-primary py-4 rounded-2xl text-white font-bold text-sm shadow-lg shadow-primary/30 hover:bg-blue-600 transition-all active:scale-[0.98]">
                        <span class="material-symbols-outlined text-lg">save</span>
                        <span>Simpan Penilaian</span>
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        function updateNilai(id, value) {
            document.getElementById(id).innerText = value;
            calculateAverage();
        }

        function calculateAverage() {
            const inputs = document.querySelectorAll('.input-nilai');
            let total = 0;

            inputs.forEach(input => {
                total += parseInt(input.value) || 0;
            });

            // Hitung rata-rata berdasarkan jumlah input yang dirender (4 untuk PI, 2 untuk GP)
            let average = inputs.length > 0 ? (total / inputs.length) : 0;

            document.getElementById('rata-rata-display').innerText = Math.round(average);
        }

        // Jalankan saat pertama kali halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            calculateAverage();
        });
    </script>
@endsection
