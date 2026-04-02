@extends('layouts.pembimbing')

@section('title', 'Monitoring Absensi - SMKN 5 Pekanbaru')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Monitoring Absensi',
        'backUrl' => url('/pembimbing'),
    ])

    <main class="flex-1 overflow-y-auto no-scrollbar pb-32 px-4 pt-6 bg-slate-50 dark:bg-gray-900">

        {{-- Tanggal Hari Ini --}}
        <div class="mb-6 flex justify-center">
            <button
                class="group flex items-center gap-3 rounded-full bg-white dark:bg-gray-800 px-6 py-3 shadow-sm border border-slate-200 dark:border-gray-700 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-primary text-xl">calendar_month</span>
                <span class="text-slate-900 dark:text-white text-sm font-bold tracking-wider uppercase">
                    {{ $today->translatedFormat('d F Y') }}
                </span>
            </button>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div
                class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 text-center shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Sudah Absen
                </p>
                <p class="text-2xl font-bold text-green-600">{{ $sudahAbsen }}</p>
            </div>
            <div
                class="bg-white dark:bg-gray-800 p-4 rounded-3xl border border-slate-100 dark:border-gray-700 text-center shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Belum
                    Absen</p>
                <p class="text-2xl font-bold text-red-500">{{ $belumAbsen }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Daftar Siswa Bimbingan</h3>
                <span
                    class="text-[10px] font-bold text-slate-400 px-2 py-0.5 rounded-full bg-slate-200/50 dark:bg-gray-700">{{ $totalSiswa }}
                    Siswa</span>
            </div>

            {{-- Looping Data Siswa --}}
            @forelse ($dataSiswa as $item)
                @php
                    $absen = $item['absensi'];
                    $siswa = $item['siswa'];
                    $pkl = $item['pkl'];
                @endphp

                <div
                    class="bg-white dark:bg-gray-800 rounded-[2rem] p-5 border border-slate-100 dark:border-gray-700 shadow-sm transition-all hover:border-primary/20">
                    <div class="flex items-center gap-4">
                        {{-- Avatar --}}
                        <div
                            class="relative h-14 w-14 shrink-0 overflow-hidden rounded-2xl border-2 border-slate-100 dark:border-gray-700 bg-slate-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-400 text-3xl">person</span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-slate-900 dark:text-white text-base font-bold truncate">{{ $siswa->nama }}</p>

                            @if ($absen)
                                <div
                                    class="flex items-center gap-1.5 mt-1 text-slate-500 dark:text-slate-400 font-semibold">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <p class="text-[11px]">{{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }} WIB
                                    </p>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5 mt-1 text-slate-400 font-semibold">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <p class="text-[11px]">-- : --</p>
                                </div>
                            @endif
                        </div>

                        {{-- Badge Status --}}
                        <div class="shrink-0">
                            @if (!$absen)
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-slate-100 dark:bg-gray-700 px-3 py-1 text-[10px] font-bold text-slate-500 border border-slate-200 dark:border-gray-600">Belum
                                    Absen</span>
                            @elseif($absen->status_kehadiran === 'Hadir')
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-green-50 dark:bg-green-900/20 px-3 py-1 text-[10px] font-bold text-green-600 border border-green-100 dark:border-green-900/30">Hadir</span>
                            @elseif(in_array($absen->status_kehadiran, ['Izin', 'Sakit']))
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-amber-50 dark:bg-amber-900/20 px-3 py-1 text-[10px] font-bold text-amber-600 border border-amber-100 dark:border-amber-900/30">{{ $absen->status_kehadiran }}</span>
                            @else
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-red-50 dark:bg-red-900/20 px-3 py-1 text-[10px] font-bold text-red-500 border border-red-100 dark:border-red-900/30">Alpha</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-50 dark:border-gray-700 flex justify-end gap-2">

                        {{-- Tombol Lihat Bukti & Validasi jika Izin/Sakit dan masih Menunggu --}}
                        @if ($absen && in_array($absen->status_kehadiran, ['Izin', 'Sakit']) && $absen->status_validasi === 'Menunggu')
                            {{-- Gunakan asset() atau path storage yang sesuai untuk url foto --}}
                            @php
                                $fotoUrl = $absen->foto ? asset('storage/' . $absen->foto) : null;
                            @endphp

                            <button
                                onclick="lihatBukti('{{ $fotoUrl }}', '{{ $absen->id }}', '{{ $siswa->nama }}')"
                                class="flex items-center gap-1.5 px-4 py-2 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-xl text-xs font-bold hover:bg-amber-100 transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                <span>Lihat Bukti</span>
                            </button>

                            {{-- Form Tersembunyi untuk Update Validasi --}}
                            <form id="form-validasi-{{ $absen->id }}"
                                action="{{ url('/pembimbing/monitoring_absensi/validasi/' . $absen->id) }}" method="POST"
                                class="hidden">
                                @csrf
                            </form>
                        @endif

                        {{-- Tombol Detail Mengarah ke Detail Absensi Siswa --}}
                        <a href="{{ url('/pembimbing/monitoring_absensi/detail_siswa/' . $pkl->id) }}"
                            class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 dark:bg-gray-700 text-primary dark:text-blue-400 rounded-xl text-xs font-bold hover:bg-primary/5 transition-colors group">
                            <span>Detail Riwayat</span>
                            <span
                                class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-slate-500 text-sm">Belum ada siswa bimbingan yang terdaftar.</p>
                </div>
            @endforelse

        </div>
    </main>

    {{-- Script untuk menampilkan Foto Bukti Izin --}}
    <script>
        function lihatBukti(urlFoto, idAbsen, namaSiswa) {
            if (!urlFoto || urlFoto === '') {
                Swal.fire('Tidak Ada Foto', 'Siswa tidak melampirkan foto bukti.', 'info');
                return;
            }

            Swal.fire({
                title: 'Bukti Izin - ' + namaSiswa,
                imageUrl: urlFoto,
                imageAlt: 'Bukti Izin/Sakit',
                showCancelButton: true,
                confirmButtonText: '<span class="material-symbols-outlined align-middle mr-1">check_circle</span> Terima Izin',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#10b981', // Warna hijau sukses
                cancelButtonColor: '#64748b',
                customClass: {
                    image: 'rounded-xl max-h-96 object-contain'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika klik tombol hijau, jalankan form validasi
                    document.getElementById('form-validasi-' + idAbsen).submit();
                }
            });
        }
    </script>
@endsection
