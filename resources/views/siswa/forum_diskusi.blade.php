@extends('layouts.siswa')

@section('title', 'Forum Diskusi - Bios Komputer')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Forum Bios Komputer',
        'backUrl' => url('/siswa')
    ])

    <div class="flex flex-col h-[calc(100vh-136px)] bg-slate-50 dark:bg-gray-900">

        <div class="flex-1 overflow-y-auto p-4 space-y-6 no-scrollbar">
            <div class="flex justify-center">
                <span class="text-[10px] font-bold text-slate-400 bg-slate-200/50 dark:bg-gray-700/50 px-3 py-1 rounded-full uppercase tracking-widest">Hari Ini</span>
            </div>

            <div class="flex items-end gap-3 max-w-[85%] sm:max-w-[70%]">
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-primary/20 flex items-center justify-center shrink-0 border border-blue-200 dark:border-primary/30">
                    <span class="material-symbols-outlined text-primary text-sm">school</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] font-bold text-primary ml-1 uppercase tracking-tighter">Guru Pembimbing</span>
                    <div class="bg-white dark:bg-gray-800 text-slate-800 dark:text-slate-200 px-4 py-3 rounded-2xl rounded-bl-none shadow-sm border border-slate-100 dark:border-gray-700 text-sm leading-relaxed">
                        Selamat pagi anak-anak, jangan lupa untuk segera mengunggah laporan jurnal harian minggu ini ya.
                    </div>
                    <span class="text-[9px] text-slate-400 ml-1">08:30 WIB</span>
                </div>
            </div>

            <div class="flex flex-col items-end gap-1 ml-auto max-w-[85%] sm:max-w-[70%]">
                <div class="flex items-end gap-3 justify-end">
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-[10px] font-bold text-slate-400 mr-1 uppercase tracking-tighter">Anda</span>
                        <div class="bg-primary text-white px-4 py-3 rounded-2xl rounded-br-none shadow-md shadow-primary/20 text-sm leading-relaxed">
                            Baik Pak, segera saya lengkapi. Saat ini sedang proses dokumentasi.
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-gray-700 flex items-center justify-center shrink-0 border border-slate-300 dark:border-gray-600">
                        <span class="material-symbols-outlined text-slate-500 text-sm">person</span>
                    </div>
                </div>
                <div class="flex items-center gap-1 mr-11">
                    <span class="text-[9px] text-slate-400">09:15</span>
                    <span class="material-symbols-outlined text-[14px] text-primary">done_all</span>
                </div>
            </div>

            <div class="flex items-end gap-3 max-w-[85%] sm:max-w-[70%]">
                <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/20 flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-900/30">
                    <span class="material-symbols-outlined text-amber-600 text-sm">engineering</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] font-bold text-amber-600 ml-1 uppercase tracking-tighter">Mentor Lapangan</span>
                    <div class="bg-white dark:bg-gray-800 text-slate-800 dark:text-slate-200 px-4 py-3 rounded-2xl rounded-bl-none shadow-sm border border-slate-100 dark:border-gray-700 text-sm leading-relaxed">
                        Besok kita ada briefing pagi jam 08:00 WIB di ruang server ya, Dimas.
                    </div>
                    <span class="text-[9px] text-slate-400 ml-1">10:05 WIB</span>
                </div>
            </div>

            <div class="flex items-center gap-2 text-slate-400 animate-pulse ml-11">
                <div class="flex gap-1">
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce"></span>
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                </div>
                <span class="text-[10px] font-medium uppercase tracking-widest">Mentor sedang mengetik...</span>
            </div>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 border-t border-slate-100 dark:border-gray-700">
            <div class="max-w-2xl mx-auto flex items-end gap-2">
                <button class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-slate-50 dark:bg-gray-700 text-slate-500 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">add</span>
                </button>

                <div class="flex-1 relative flex items-center">
                    <textarea rows="1"
                        class="w-full bg-slate-50 dark:bg-gray-700 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/10 rounded-2xl px-4 py-3 text-sm dark:text-white placeholder:text-slate-400 transition-all resize-none no-scrollbar"
                        placeholder="Ketik pesan diskusi..."></textarea>
                    <button class="absolute right-3 text-slate-400 hover:text-amber-500 transition-colors">
                        <span class="material-symbols-outlined text-xl">sentiment_satisfied</span>
                    </button>
                </div>

                <button class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-primary/20 hover:bg-blue-600 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-xl ml-0.5">send</span>
                </button>
            </div>
        </div>
    </div>
@endsection
