{{-- DYNAMIC LAYOUT: Cek role user, ekstensi layout yang sesuai --}}
@extends(Auth::user()->role === 'siswa' ? 'layouts.siswa' : 'layouts.pembimbing')

@section('title', 'Profil Pengguna - SMKN 5 Pekanbaru')

@section('content')
    <div class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-slate-100 dark:border-gray-800">
        <div class="flex items-center justify-between p-4 max-w-lg mx-auto">
            <button onclick="history.back()" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 dark:bg-gray-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-gray-700 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </button>
            <h1 class="text-base font-bold text-slate-800 dark:text-white">Pengaturan Profil</h1>
            <div class="w-10"></div> {{-- Spacer --}}
        </div>
    </div>

    <main class="flex-1 w-full max-w-lg mx-auto p-4 flex flex-col gap-6 pb-32">

        {{-- ALERTS --}}
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold border border-green-100 dark:border-green-800">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold border border-red-100 dark:border-red-800">
                <span class="material-symbols-outlined">error</span>
                Terjadi kesalahan pada input Anda.
            </div>
        @endif

        {{-- INFO HEADER CARD --}}
        <div class="bg-gradient-to-br from-primary to-blue-700 rounded-[2rem] p-6 shadow-lg shadow-primary/20 text-white flex items-center gap-4 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-2xl font-bold backdrop-blur-sm relative z-10 border border-white/30">
                {{ strtoupper(substr($profileData->nama, 0, 2)) }}
            </div>
            <div class="relative z-10">
                <h2 class="text-lg font-bold leading-tight">{{ $profileData->nama }}</h2>
                <p class="text-xs text-blue-100 mt-1 uppercase tracking-wider">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
            </div>
        </div>

        {{-- FORM UPDATE DATA PRIBADI --}}
        <section class="bg-white dark:bg-gray-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-2 mb-6">
                <span class="material-symbols-outlined text-primary">person</span>
                <h3 class="font-bold text-slate-800 dark:text-white">Data Pribadi</h3>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Field Global --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $profileData->nama) }}" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all" required>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Email Terdaftar</label>
                    <input type="email" name="gmail" value="{{ old('gmail', $user->gmail) }}" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all" required>
                            <option value="Laki-laki" {{ $profileData->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $profileData->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">Agama</label>
                        <select name="agama" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all" required>
                            <option value="Islam" {{ $profileData->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ $profileData->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ $profileData->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ $profileData->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ $profileData->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">No. Telepon/WhatsApp</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $profileData->nomor_telepon) }}" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all" required>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all" required>{{ old('alamat', $profileData->alamat) }}</textarea>
                </div>

                {{-- Field Khusus Berdasarkan Role --}}
                @if($user->role === 'siswa')
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">No. Telepon Wali</label>
                        <input type="text" name="nomor_telepon_wali" value="{{ old('nomor_telepon_wali', $profileData->nomor_telepon_wali) }}" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all">
                    </div>
                    {{-- Readonly Data Akademi --}}
                    <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-slate-100 dark:border-gray-700">
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">NISN</label>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $profileData->nisn }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">Kelas & Jurusan</label>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $profileData->kelas }} - {{ $profileData->jurusan }}</p>
                        </div>
                    </div>
                @endif

                @if($user->role === 'pembimbing_industri')
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase">Jabatan di Industri</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $profileData->jabatan) }}" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary dark:text-white transition-all" required>
                    </div>
                @endif

                @if($user->role === 'guru_pembimbing')
                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-gray-700">
                        <label class="text-xs font-bold text-slate-400 uppercase">NIP</label>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $profileData->nip }}</p>
                    </div>
                @endif

                <button type="submit" class="w-full mt-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold py-3 rounded-xl hover:opacity-90 active:scale-[0.98] transition-all">
                    Simpan Perubahan Data
                </button>
            </form>
        </section>

        {{-- FORM UBAH PASSWORD --}}
        <section class="bg-white dark:bg-gray-800 rounded-[2rem] p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-2 mb-6">
                <span class="material-symbols-outlined text-amber-500">lock</span>
                <h3 class="font-bold text-slate-800 dark:text-white">Ubah Password</h3>
            </div>

            <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Password Saat Ini</label>
                    <input type="password" name="current_password" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500 dark:text-white transition-all" required>
                    @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Password Baru</label>
                    <input type="password" name="new_password" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500 dark:text-white transition-all" required>
                    @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="mt-1 w-full bg-slate-50 dark:bg-gray-900 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500 dark:text-white transition-all" required>
                </div>

                <button type="submit" class="w-full mt-4 bg-amber-500 text-white font-bold py-3 rounded-xl hover:bg-amber-600 active:scale-[0.98] transition-all shadow-lg shadow-amber-500/30">
                    Perbarui Password
                </button>
            </form>
        </section>

        {{-- LOGOUT BUTTON --}}
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-bold py-4 rounded-2xl hover:bg-red-100 dark:hover:bg-red-900/40 active:scale-[0.98] transition-all">
                <span class="material-symbols-outlined">logout</span>
                Keluar Aplikasi
            </button>
        </form>

    </main>
@endsection
