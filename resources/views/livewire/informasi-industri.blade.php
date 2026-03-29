<div>
    {{-- SEARCH & FILTER --}}
    <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 border-b border-slate-100 dark:border-gray-700 sticky top-16 z-10 shadow-sm">
        <div class="max-w-4xl mx-auto space-y-4">
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>

                {{-- wire:model.live="search" inilah yang membuat pencarian langsung jalan tanpa Enter --}}
                <input type="text"
                       wire:model.live="search"
                       placeholder="Cari nama perusahaan atau lokasi..."
                       class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 text-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none dark:text-white">
            </div>

            <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                <button class="px-4 py-2 rounded-full bg-primary text-white text-[11px] font-bold uppercase tracking-wider whitespace-nowrap shadow-md shadow-primary/20">Semua Mitra</button>
            </div>
        </div>
    </div>

    {{-- LIST INDUSTRI --}}
    <main class="p-4 sm:p-6 pb-20">
        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($industris as $industri)
                <div class="group bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-blue-50 dark:bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">domain</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white truncate">{{ $industri->nama }}</h3>
                                <span class="px-2 py-0.5 rounded-md bg-green-100 dark:bg-green-900/30 text-green-600 text-[9px] font-extrabold uppercase tracking-tighter">Aktif</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-sm">location_on</span> {{ \Illuminate\Support\Str::limit($industri->alamat, 40) }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-50 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Kontak</span>
                            <span class="text-[10px] font-bold text-slate-900 dark:text-white">{{ $industri->nomor_telepon }}</span>
                        </div>
                        <a href="{{ url('/pengajuan/form_pengajuan') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                            Pilih Tempat <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <h3 class="text-slate-900 dark:text-white font-bold">Mitra tidak ditemukan</h3>
                    <p class="text-slate-500 text-sm">Coba kata kunci lain.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
