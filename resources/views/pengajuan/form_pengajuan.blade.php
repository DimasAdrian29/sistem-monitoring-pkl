@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Status Pengajuan PKL')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Status Pengajuan PKL',
        'backUrl' => url('/pengajuan'),
    ])

    @php
        $status = $pengajuan ? $pengajuan->status_pengajuan : 'Belum';
    @endphp

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">

        <div class="px-6 py-8 bg-white dark:bg-gray-800 border-b border-slate-100 dark:border-gray-700">
            <div class="relative flex items-center justify-between max-w-xs mx-auto">
                <div class="absolute left-0 top-4 h-0.5 w-full bg-slate-200 dark:bg-gray-700"></div>

                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full {{ $status == 'Belum' ? 'bg-primary text-white' : 'bg-green-500 text-white' }}">
                        <span class="material-symbols-outlined text-xs">{{ $status == 'Belum' ? 'edit' : 'check' }}</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider">Pengajuan</span>
                </div>

                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full {{ $status == 'Menunggu' ? 'bg-primary text-white animate-pulse' : ($status == 'Diterima' || $status == 'Ditolak' ? 'bg-green-500 text-white' : 'bg-white border-2 border-slate-200 text-slate-400') }}">
                        <span class="text-xs font-bold">2</span>
                    </div>
                    <span class="text-[10px] font-semibold uppercase tracking-wider">Proses</span>
                </div>

                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full {{ $status == 'Diterima' || $status == 'Ditolak' ? 'bg-primary text-white' : 'bg-white border-2 border-slate-200 text-slate-400' }}">
                        <span class="text-xs font-bold">3</span>
                    </div>
                    <span class="text-[10px] font-semibold uppercase tracking-wider">Hasil</span>
                </div>
            </div>
        </div>

        <main class="flex-1 p-4 sm:p-6 pb-36">
            <div class="max-w-2xl mx-auto">

                @if ($status == 'Belum')
                    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <div
                            class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 space-y-8">
                            <div class="space-y-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined text-primary text-xl">person</span>
                                    <h3 class="text-slate-900 dark:text-white font-bold text-base">Data Diri</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama
                                            Lengkap</label>
                                        <input type="text" value="{{ $siswa->nama }}" readonly
                                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-semibold text-slate-500 outline-none">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kelas
                                            / Jurusan</label>
                                        <input type="text" value="{{ $siswa->kelas }} / {{ $siswa->jurusan }}" readonly
                                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-semibold text-slate-500 outline-none">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 pt-4 border-t border-slate-100">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined text-primary text-xl">domain</span>
                                    <h3 class="text-slate-900 dark:text-white font-bold text-base">Pilih Industri</h3>
                                </div>
                                <select name="industri_id" required
                                    class="w-full rounded-2xl border border-slate-200 dark:border-gray-600 bg-slate-50 dark:bg-gray-700 px-4 py-3.5 text-sm">
                                    <option disabled selected value="">Pilih mitra industri...</option>
                                    @foreach ($industris as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-4 pt-4 border-t border-slate-100">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined text-primary text-xl">upload_file</span>
                                    <h3 class="text-slate-900 dark:text-white font-bold text-base">Unggah Berkas (CV)</h3>
                                </div>
                                <input type="file" name="cv" required accept=".pdf"
                                    class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            </div>
                        </div>

                        <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-t p-4 pb-8">
                            <div class="max-w-2xl mx-auto">
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-3 rounded-2xl bg-primary py-4 text-sm font-bold text-white shadow-lg">
                                    <span>Kirim Pengajuan</span>
                                    <span class="material-symbols-outlined text-lg">send</span>
                                </button>
                            </div>
                        </div>
                    </form>
                @elseif($status == 'Menunggu')
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl p-10 text-center shadow-sm border border-slate-100 dark:border-gray-700">
                        <div
                            class="h-24 w-24 bg-blue-50 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="material-symbols-outlined text-5xl animate-spin">sync</span>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Pengajuan Sedang Diproses</h2>
                        <p class="text-slate-500">Mohon tunggu, Admin atau Guru Pembimbing sedang meninjau dokumen dan
                            pilihan industrimu.</p>
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl p-10 text-center shadow-sm border border-slate-100 dark:border-gray-700">
                        @if ($status == 'Diterima')
                            <div
                                class="h-24 w-24 bg-green-50 dark:bg-green-900/20 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-5xl">verified</span>
                            </div>

                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Selamat, Pengajuan Diterima!
                            </h2>

                            <div
                                class="bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-900/30 rounded-2xl p-4 mb-8">
                                <p class="text-green-700 dark:text-green-400 text-sm leading-relaxed">
                                    Pengajuan magang kamu di <strong>{{ $pengajuan->industri->nama }}</strong> telah
                                    disetujui.
                                    <br><br>
                                    <span class="font-bold">Langkah Selanjutnya:</span><br>
                                    Silakan tunggu pihak Humas mengatur Guru Pembimbing dan Pembimbing Industri untukmu.
                                    Kamu akan dipindahkan ke Dashboard Monitoring setelah proses plotting selesai.
                                </p>
                            </div>

                            {{-- Tombol Dashboard kita ganti menjadi tombol status "Menunggu" atau bisa diarahkan ke info kontak Humas --}}
                            <div
                                class="w-full flex items-center justify-center gap-3 rounded-2xl bg-slate-100 dark:bg-gray-700 py-4 text-sm font-bold text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-gray-600">
                                <span class="material-symbols-outlined text-lg animate-pulse">hourglass_empty</span>
                                <span>Menunggu Penempatan Pembimbing</span>
                            </div>
                        @else
                            <div
                                class="h-24 w-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-5xl">cancel</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Maaf, Pengajuan Ditolak</h2>
                            <p class="text-slate-500 mb-8">Jangan menyerah! Kamu bisa mencoba mengajukan kembali ke mitra
                                industri lainnya.</p>

                            <form action="{{ route('pengajuan.reset') }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold">Daftar Lagi</button>
                            </form>
                        @endif
                    </div>
                @endif

            </div>
        </main>
    </div>
@endsection
