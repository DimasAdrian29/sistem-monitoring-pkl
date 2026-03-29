@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Pendaftaran PKL - SMKN 5 Pekanbaru')

@section('content')
    <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">

        <main class="flex-1 flex flex-col justify-center p-4 sm:p-10">
            <div class="max-w-6xl mx-auto w-full">

                <div class="mb-6">
                    <div
                        class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-[#0d6efd] to-[#0a58ca] shadow-lg">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-32 w-32 rounded-full bg-black/10 blur-3xl"></div>

                        {{-- Ganti bagian header kartu biru --}}
                        <div class="relative flex flex-col items-start p-8 sm:p-14">
                            <div
                                class="mb-4 inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 backdrop-blur-md border border-white/10">
                                <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
                                <span class="text-[10px] sm:text-[11px] font-bold text-white uppercase tracking-widest">
                                    Status: Belum Terdaftar Magang
                                </span>
                            </div>
                            <div class="flex w-full flex-col">
                                {{-- NAMA DINAMIS DI SINI --}}
                                <h1 class="text-white text-3xl sm:text-5xl font-bold tracking-tight">
                                    Halo, {{ $siswa ? $siswa->nama : auth()->user()->username }}
                                </h1>
                                <p class="text-blue-100/80 text-sm sm:text-lg mt-3 max-w-xl leading-relaxed">
                                    Silahkan pelajari informasi dan lengkapi pendaftaran untuk memulai program PKL Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">

                    <a href="{{ url('/pengajuan/form_pengajuan') }}"
                        class="group flex flex-col items-center justify-center bg-white dark:bg-gray-800 p-6 sm:p-12 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-gray-700 hover:shadow-xl hover:border-primary/30 transition-all duration-300">
                        <div
                            class="flex h-16 w-16 sm:h-24 sm:w-24 shrink-0 items-center justify-center rounded-3xl bg-blue-50 dark:bg-blue-900/30 text-[#0d6efd] mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-4xl sm:text-5xl">description</span>
                        </div>
                        <div class="text-center">
                            <span class="text-slate-900 dark:text-white font-bold text-sm sm:text-xl block">Pengajuan
                                PKL</span>
                            <span
                                class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs mt-1 block uppercase tracking-tighter">Daftar
                                Tempat Magang</span>
                        </div>
                    </a>

                    <a href="{{ url('/pengajuan/informasi_pkl') }}"
                        class="group flex flex-col items-center justify-center bg-white dark:bg-gray-800 p-6 sm:p-12 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-gray-700 hover:shadow-xl hover:border-primary/30 transition-all duration-300">
                        <div
                            class="flex h-16 w-16 sm:h-24 sm:w-24 shrink-0 items-center justify-center rounded-3xl bg-blue-50 dark:bg-blue-900/30 text-[#0d6efd] mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-4xl sm:text-5xl">info</span>
                        </div>
                        <div class="text-center">
                            <span class="text-slate-900 dark:text-white font-bold text-sm sm:text-xl block">Informasi
                                PKL</span>
                            <span
                                class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs mt-1 block uppercase tracking-tighter">Daftar
                                Mitra Aktif</span>
                        </div>
                    </a>

                    <a href="{{ url('/pengajuan/peraturan_pkl') }}"
                        class="group flex flex-col items-center justify-center bg-white dark:bg-gray-800 p-6 sm:p-12 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-gray-700 hover:shadow-xl hover:border-primary/30 transition-all duration-300">
                        <div
                            class="flex h-16 w-16 sm:h-24 sm:w-24 shrink-0 items-center justify-center rounded-3xl bg-blue-50 dark:bg-blue-900/30 text-[#0d6efd] mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-4xl sm:text-5xl">rule</span>
                        </div>
                        <div class="text-center">
                            <span class="text-slate-900 dark:text-white font-bold text-sm sm:text-xl block">Peraturan
                                PKL</span>
                            <span
                                class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs mt-1 block uppercase tracking-tighter">Tata
                                Tertib Magang</span>
                        </div>
                    </a>

                </div>

                <div class="mt-12 text-center">
                    <p
                        class="text-slate-400 text-[10px] sm:text-xs leading-relaxed max-w-md mx-auto uppercase tracking-widest font-medium">
                        Sistem Informasi Praktek Kerja Lapangan • SMKN 5 Pekanbaru
                    </p>
                </div>

            </div>
        </main>
    </div>
@endsection
