@extends('layouts.siswa')

@section('title', 'Jurnal Harian - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Jurnal Harian',
        'backUrl' => url('/siswa'),
    ])

    <main class="flex-1 overflow-y-auto no-scrollbar pb-24 px-4 sm:px-6 pt-6 relative">

        {{-- TOMBOL ISI JURNAL DINAMIS --}}
        <div class="mb-8">
            @if ($hasFilledToday)
                <div
                    class="w-full flex items-center justify-center gap-3 bg-slate-100 dark:bg-gray-800 text-slate-400 rounded-2xl h-16 border border-slate-200 dark:border-gray-700 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[28px]">task_alt</span>
                    <span class="text-base font-bold tracking-wide">Sudah Mengisi Jurnal Hari Ini</span>
                </div>
            @else
                <a href="{{ url('/siswa/jurnal_harian/form_jurnal_harian') }}"
                    class="w-full flex items-center justify-center gap-3 bg-primary hover:bg-blue-600 active:scale-[0.98] text-white rounded-2xl h-16 shadow-lg shadow-blue-500/20 transition-all duration-200 group">
                    <span
                        class="material-symbols-outlined text-[28px] group-hover:rotate-90 transition-transform duration-300">add_circle</span>
                    <span class="text-base font-bold tracking-wide">Isi Jurnal Harian Hari Ini</span>
                </a>
            @endif
        </div>

        <div class="flex items-center justify-between mb-4 px-1">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="h-5 w-1 bg-primary rounded-full"></span>
                Riwayat Jurnal
            </h3>
        </div>

        <div class="flex flex-col gap-4">
            @forelse($logbooks as $log)
                @php
                    $tanggal = \Carbon\Carbon::parse($log->tanggal);
                    $statusClasses = [
                        'Menunggu' =>
                            'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-900/30',
                        'Disetujui' =>
                            'bg-green-50 text-green-700 border-green-100 dark:bg-green-900/20 dark:text-green-400 dark:border-green-900/30',
                        'Ditolak' =>
                            'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-900/30',
                    ];
                    $dotClasses = [
                        'Menunggu' => 'bg-amber-600',
                        'Disetujui' => 'bg-green-600 animate-pulse',
                        'Ditolak' => 'bg-red-600',
                    ];
                @endphp

                <div
                    class="group flex items-start gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:border-primary/30 transition-all">
                    {{-- Kotak Tanggal --}}
                    <div
                        class="flex flex-col items-center justify-center shrink-0 w-14 h-14 mt-1 {{ $log->status_validasi == 'Ditolak' ? 'bg-red-50 dark:bg-red-900/10 border-red-100' : 'bg-blue-50 dark:bg-primary/10 border-blue-100' }} rounded-xl border">
                        <span
                            class="text-[10px] font-bold {{ $log->status_validasi == 'Ditolak' ? 'text-red-500' : 'text-primary' }} uppercase tracking-widest">
                            {{ $tanggal->translatedFormat('M') }}
                        </span>
                        <span class="text-xl font-bold text-slate-900 dark:text-white leading-none">
                            {{ $tanggal->format('d') }}
                        </span>
                    </div>

                    {{-- Detail Kegiatan --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-2">
                                {{ $log->kegiatan }}
                            </h4>
                            <div class="shrink-0 mt-0.5">
                                <div
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border {{ $statusClasses[$log->status_validasi] ?? '' }}">
                                    <span
                                        class="h-1.5 w-1.5 rounded-full {{ $dotClasses[$log->status_validasi] ?? 'bg-slate-400' }}"></span>
                                    <span class="text-[10px] font-bold">{{ $log->status_validasi }}</span>
                                </div>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">
                            {{ $log->status_validasi == 'Ditolak' ? 'Klik untuk lihat alasan penolakan' : 'Kegiatan PKL Terlaksana' }}
                        </p>

                        {{-- Tombol memanggil JavaScript fungsi openModal() --}}
                        @if ($log->foto)
                            <button type="button" onclick="openModal('{{ asset('storage/' . $log->foto) }}')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-slate-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 text-slate-600 hover:text-primary dark:text-slate-300 dark:hover:text-blue-400 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-gray-600 transition-all w-fit cursor-pointer">
                                <span class="material-symbols-outlined text-[14px]">photo_camera</span>
                                Lihat Dokumentasi
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div
                        class="h-20 w-20 bg-slate-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl text-slate-300">history_edu</span>
                    </div>
                    <p class="text-slate-500 text-sm">Belum ada riwayat jurnal harian.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION LINKS DITAMBAHKAN DI SINI --}}
        <div class="mt-6">
            {{ $logbooks->links() }}
        </div>

        <div
            class="mt-8 p-4 rounded-2xl bg-blue-50 dark:bg-primary/5 border border-blue-100 dark:border-primary/10 flex gap-3">
            <span class="material-symbols-outlined text-primary">info</span>
            <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                Jurnal harian yang Anda isi akan diverifikasi oleh pembimbing lapangan. Pastikan deskripsi pekerjaan ditulis
                dengan jelas.
            </p>
        </div>
    </main>

    {{-- MODAL POPUP GAMBAR --}}
    <div id="imageModal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="relative max-w-3xl w-full mx-4 flex flex-col items-center">

            {{-- Tombol Close (X) --}}
            <button onclick="closeModal()"
                class="absolute -top-12 right-0 md:-right-10 text-white/70 hover:text-white bg-black/20 hover:bg-black/50 p-2 rounded-full transition-all">
                <span class="material-symbols-outlined text-3xl block">close</span>
            </button>

            {{-- Tempat Gambar --}}
            <img id="modalImage" src="" alt="Dokumentasi Jurnal"
                class="max-h-[85vh] w-auto rounded-xl shadow-2xl object-contain scale-95 transition-transform duration-300">
        </div>
    </div>

    {{-- SCRIPT UNTUK KONTROL MODAL --}}
    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');

        function openModal(imageSrc) {
            modalImg.src = imageSrc;

            // Tampilkan modal
            modal.classList.remove('hidden');

            // Sedikit delay untuk efek transisi opacity dan scale
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalImg.classList.remove('scale-95');
                modalImg.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            // Efek menutup
            modal.classList.add('opacity-0');
            modalImg.classList.remove('scale-100');
            modalImg.classList.add('scale-95');

            // Sembunyikan setelah efek selesai (300ms)
            setTimeout(() => {
                modal.classList.add('hidden');
                modalImg.src = ''; // Kosongkan source gambar agar tidak bocor
            }, 300);
        }

        // Tutup modal jika user mengklik area gelap di luar gambar
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Tutup modal saat menekan tombol "Escape" di keyboard
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    </script>
@endsection
