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
                <div class="w-16 h-16 rounded-2xl bg-cover bg-center overflow-hidden border-2 border-primary/20"
                     style="background-image: url('https://i.pravatar.cc/150?u=11');"></div>
                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-white text-[12px] font-bold">check</span>
                </div>
            </div>
            <div class="flex flex-col flex-1 min-w-0">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white leading-tight truncate">Dimas Adrian</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-blue-50 text-primary dark:bg-primary/10 tracking-wide uppercase">TKJ 2</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 truncate">Teknik Komputer Jaringan</span>
                </div>
            </div>
        </div>

        <form action="#" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-3">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-primary text-xl">psychology</span>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kriteria Non-Teknis</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-[2rem] border border-slate-100 dark:border-gray-700 overflow-hidden divide-y divide-slate-50 dark:divide-gray-700 shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Kedisiplinan</label>
                            <span class="text-xl font-black text-primary tabular-nums" id="val-disiplin">85</span>
                        </div>
                        <input type="range" min="0" max="100" value="85" class="w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer"
                               oninput="document.getElementById('val-disiplin').innerText = this.value">
                        <div class="flex justify-between mt-2 px-1 text-[10px] font-bold text-slate-300 uppercase tracking-tighter">
                            <span>Kurang</span>
                            <span>Sempurna</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Etika & Sikap</label>
                            <span class="text-xl font-black text-primary tabular-nums" id="val-sikap">90</span>
                        </div>
                        <input type="range" min="0" max="100" value="90" class="w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer"
                               oninput="document.getElementById('val-sikap').innerText = this.value">
                        <div class="flex justify-between mt-2 px-1 text-[10px] font-bold text-slate-300 uppercase tracking-tighter">
                            <span>Kurang</span>
                            <span>Sempurna</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-primary text-xl">terminal</span>
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kriteria Teknis</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-[2rem] border border-slate-100 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <label class="text-sm font-bold text-slate-700 dark:text-slate-200">Kemampuan Hard Skill</label>
                        <span class="text-xl font-black text-primary tabular-nums" id="val-skill">80</span>
                    </div>
                    <input type="range" min="0" max="100" value="80" class="w-full accent-primary h-2 bg-slate-100 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer"
                           oninput="document.getElementById('val-skill').innerText = this.value">
                    <div class="flex justify-between mt-2 px-1 text-[10px] font-bold text-slate-300 uppercase tracking-tighter">
                        <span>Kurang</span>
                        <span>Sempurna</span>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden bg-gradient-to-br from-primary to-blue-700 rounded-[2rem] p-6 shadow-lg shadow-primary/20 border border-white/10 text-white">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative flex items-center justify-between z-10">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest opacity-80">Rata-rata Nilai</p>
                        <p class="text-xs mt-1 opacity-70 italic">Automated calculation</p>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-black tracking-tighter">85</span>
                        <span class="text-sm font-bold opacity-60">/ 100</span>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <div class="fixed bottom-0 left-0 right-0 p-4 pb-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-t border-slate-100 dark:border-gray-700 z-50">
        <div class="max-w-lg mx-auto">
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-primary py-4 rounded-2xl text-white font-bold text-sm shadow-lg shadow-primary/30 hover:bg-blue-600 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-lg">save</span>
                <span>Simpan Penilaian</span>
            </button>
        </div>
    </div>
@endsection
