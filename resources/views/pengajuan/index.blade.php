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

    {{-- AWAL POP UP FORM LENGKAPI DATA --}}
    @php
        $dataBelumLengkap = false;

        // Cek apakah ada field yang masih kosong
        if ($siswa) {
            if (
                empty($siswa->jenis_kelamin) ||
                empty($siswa->agama) ||
                empty($siswa->alamat) ||
                empty($siswa->nomor_telepon) ||
                empty($siswa->nomor_telepon_wali)
            ) {
                $dataBelumLengkap = true;
            }
        }
    @endphp

    @if($dataBelumLengkap && $siswa)
        <div id="incompleteDataPopup" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity p-4 sm:p-0 overflow-y-auto">
            <div class="bg-white dark:bg-gray-800 rounded-3xl w-full max-w-2xl shadow-2xl relative transform transition-all my-8">

                {{-- Header Pop Up --}}
                <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-yellow-500 text-3xl">warning</span>
                        Lengkapi Profil Anda!
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Kami mendeteksi ada data profil Anda yang masih kosong. Silakan lengkapi form di bawah ini sebelum melakukan pengajuan PKL.
                    </p>
                </div>

                {{-- Form Body --}}
                <form action="{{ url('/pengajuan/lengkapi-profil') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-5 max-h-[55vh] overflow-y-auto">

                        {{-- Nama Lengkap (Readonly) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                            <input type="text" value="{{ $siswa->nama }}" readonly class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 cursor-not-allowed shadow-sm sm:text-sm">
                            <p class="text-[10px] text-gray-400 mt-1">*Nama lengkap tidak dapat diubah</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#0d6efd] focus:ring-[#0d6efd] sm:text-sm">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            {{-- Agama --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Agama <span class="text-red-500">*</span></label>
                                <select name="agama" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#0d6efd] focus:ring-[#0d6efd] sm:text-sm">
                                    <option value="">Pilih Agama</option>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ $siswa->agama == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat" required rows="3" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#0d6efd] focus:ring-[#0d6efd] sm:text-sm" placeholder="Contoh: Jl. Merdeka No. 10, Pekanbaru...">{{ $siswa->alamat }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Nomor Telepon --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telepon/WA Siswa <span class="text-red-500">*</span></label>
                                <input type="tel" name="nomor_telepon" value="{{ $siswa->nomor_telepon }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#0d6efd] focus:ring-[#0d6efd] sm:text-sm" placeholder="08123456789">
                            </div>

                            {{-- Nomor Telepon Wali --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telepon/WA Wali <span class="text-red-500">*</span></label>
                                <input type="tel" name="nomor_telepon_wali" value="{{ $siswa->nomor_telepon_wali }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#0d6efd] focus:ring-[#0d6efd] sm:text-sm" placeholder="08123456789">
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-3xl flex justify-end gap-3">

                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#0d6efd] hover:bg-[#0a58ca] rounded-xl shadow-lg shadow-blue-500/30 transition-colors">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    {{-- AKHIR POP UP FORM --}}

@endsection
