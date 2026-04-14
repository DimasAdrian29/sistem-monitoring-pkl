@extends('layouts.pembimbing', ['hideHeader' => true])

@section('title', 'Detail Monitoring Siswa - SMKN 5 Pekanbaru')

@section('styles')
    {{-- Memastikan SweetAlert2 ter-load sempurna --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Monitoring Siswa',
        'backUrl' => url('/pembimbing/monitoring_absensi'),
    ])

    <main class="flex-1 overflow-y-auto no-scrollbar pb-24">

        {{-- PROFIL HEADER --}}
        <div class="bg-white dark:bg-gray-800 p-6 mb-2 border-b border-slate-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center gap-5">
                <div class="relative">
                    <div
                        class="h-20 w-20 rounded-3xl bg-slate-200 border-2 border-primary/20 flex items-center justify-center shadow-inner overflow-hidden">
                        {{-- Placeholder Avatar --}}
                        <span class="material-symbols-outlined text-slate-400 text-4xl">person</span>
                    </div>
                    <span
                        class="absolute -bottom-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-green-500 border-2 border-white dark:border-gray-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white truncate">{{ $pkl->siswa->nama }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-0.5 uppercase tracking-tighter">
                        {{ $pkl->siswa->kelas }} • {{ $pkl->siswa->jurusan }}
                    </p>
                    <div class="mt-2 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-sm">business</span>
                        <span
                            class="text-[11px] font-bold text-slate-600 dark:text-slate-300">{{ $pkl->industri->nama }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB MENU --}}
        <div class="px-4 py-4 sticky top-0 z-20 bg-slate-50/90 dark:bg-gray-900/90 backdrop-blur-md">
            <div class="flex p-1 bg-slate-200/50 dark:bg-gray-800 rounded-2xl">
                <button
                    class="flex-1 flex items-center justify-center py-2.5 rounded-xl bg-white dark:bg-gray-700 shadow-sm text-sm font-bold text-primary transition-all">
                    Absensi
                </button>
                <button
                    class="flex-1 flex items-center justify-center py-2.5 rounded-xl text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-primary transition-all">
                    Jurnal Harian
                </button>
            </div>
        </div>

        {{-- KALENDER RINGKASAN --}}
        <div class="px-4 mb-6">
            <div
                class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-6 shadow-sm border border-slate-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <button class="p-2 rounded-full hover:bg-slate-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined text-slate-400">chevron_left</span>
                    </button>
                    <div class="text-center">
                        <h4 class="text-base font-bold text-slate-800 dark:text-white">
                            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Ringkasan Bulanan
                        </p>
                    </div>
                    <button class="p-2 rounded-full hover:bg-slate-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                    </button>
                </div>

                <div class="grid grid-cols-7 text-center mb-2">
                    @foreach (['M', 'S', 'S', 'R', 'K', 'J', 'S'] as $day)
                        <span class="text-[10px] font-bold text-slate-300 uppercase py-2">{{ $day }}</span>
                    @endforeach

                    @for ($i = 1; $i <= \Carbon\Carbon::now()->daysInMonth; $i++)
                        <div class="relative py-2 flex flex-col items-center">
                            <span
                                class="text-sm font-semibold {{ $i == \Carbon\Carbon::now()->day ? 'text-white bg-primary rounded-full size-7 flex items-center justify-center shadow-md shadow-primary/30' : 'text-slate-700 dark:text-slate-300' }}">
                                {{ $i }}
                            </span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- RIWAYAT ABSENSI --}}
        <div class="px-4 space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Riwayat Kehadiran</h3>
                <span
                    class="text-[10px] font-bold text-slate-400 px-2 py-0.5 rounded-full bg-slate-200/50 dark:bg-gray-700">
                    {{ $absensis->count() }} Hari
                </span>
            </div>

            @forelse($absensis as $absen)
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center gap-4">
                        {{-- Icon Status --}}
                        @if ($absen->status_kehadiran === 'Hadir')
                            <div
                                class="h-12 w-12 rounded-2xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-600 shrink-0">
                                <span class="material-symbols-outlined filled">check_circle</span>
                            </div>
                        @elseif(in_array($absen->status_kehadiran, ['Izin', 'Sakit']))
                            <div
                                class="h-12 w-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600 shrink-0">
                                <span
                                    class="material-symbols-outlined">{{ $absen->status_kehadiran === 'Sakit' ? 'medication' : 'assignment_late' }}</span>
                            </div>
                        @else
                            <div
                                class="h-12 w-12 rounded-2xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500 shrink-0">
                                <span class="material-symbols-outlined">cancel</span>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l, d M Y') }}
                            </p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mt-0.5">
                                @if ($absen->status_kehadiran === 'Hadir')
                                    Masuk: {{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }}
                                @else
                                    Keterangan: {{ $absen->status_kehadiran }}
                                @endif
                            </p>
                        </div>

                        <div class="shrink-0 flex flex-col items-end gap-1">
                            <span
                                class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-tighter
                                {{ $absen->status_kehadiran === 'Hadir' ? 'bg-green-50 text-green-600 dark:bg-green-900/30' : '' }}
                                {{ in_array($absen->status_kehadiran, ['Izin', 'Sakit']) ? 'bg-amber-50 text-amber-600 dark:bg-amber-900/30' : '' }}
                                {{ $absen->status_kehadiran === 'Alpa' ? 'bg-red-50 text-red-500 dark:bg-red-900/30' : '' }}">
                                {{ $absen->status_kehadiran }}
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Aksi Izin/Sakit --}}
                    @if (in_array($absen->status_kehadiran, ['Izin', 'Sakit']) && $absen->status_validasi === 'Menunggu')
                        <div class="border-t border-slate-50 dark:border-gray-700 pt-3 flex justify-end">
                            @php
                                $fotoUrl = $absen->foto ? asset('storage/' . $absen->foto) : null;
                                $safeName = addslashes($pkl->siswa->nama);
                            @endphp
                            <button type="button"
                                class="btn-validasi flex items-center gap-1.5 px-4 py-2 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-xl text-xs font-bold hover:bg-amber-100 transition-colors"
                                data-foto="{{ $absen->foto ? asset('storage/' . $absen->foto) : '' }}"
                                data-id="{{ $absen->id }}" data-nama="{{ $pkl->siswa->nama }}">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                <span>Lihat Bukti & Validasi</span>
                            </button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-10 opacity-50">
                    <span class="material-symbols-outlined text-5xl text-slate-300">event_busy</span>
                    <p class="text-slate-500 text-sm mt-2">Belum ada riwayat absensi.</p>
                </div>
            @endforelse
        </div>
    </main>

    {{-- Panggil SweetAlert2 langsung di sini agar pasti ter-load --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua tombol yang punya class .btn-validasi
            const buttons = document.querySelectorAll('.btn-validasi');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil data dari atribut tombol
                    const urlFoto = this.getAttribute('data-foto');
                    const idAbsen = this.getAttribute('data-id');
                    const namaSiswa = this.getAttribute('data-nama');

                    console.log("Klik terdeteksi!", {
                        idAbsen,
                        namaSiswa,
                        urlFoto
                    });

                    // Cek jika foto kosong
                    if (!urlFoto || urlFoto.includes('null') || urlFoto.endsWith('/storage/')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Foto Tidak Ada',
                            text: 'Siswa tidak melampirkan foto bukti.',
                        });
                        return;
                    }

                    // Munculkan Pop Up
                    Swal.fire({
                        title: 'Bukti Izin - ' + namaSiswa,
                        imageUrl: urlFoto,
                        imageAlt: 'Foto Bukti',
                        showCancelButton: true,
                        confirmButtonText: 'Setujui Izin',
                        cancelButtonText: 'Tutup',
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#64748b',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return fetch(
                                    `{{ url('/pembimbing/monitoring_absensi/validasi') }}/${idAbsen}`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json'
                                        }
                                    })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Server Error');
                                    }
                                    return response.json();
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(`Gagal: ${error}`);
                                });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Status sudah diperbarui.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection
