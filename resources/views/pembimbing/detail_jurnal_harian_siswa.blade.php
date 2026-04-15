@extends('layouts.pembimbing')

@section('content')
    @include('pembimbing.partials.header_menu', [
        'title' => 'Detail Jurnal',
        'backUrl' => url('/pembimbing/monitoring_jurnal_harian'),
    ])

    <main class="flex-1 p-4 pt-6 bg-slate-50 dark:bg-gray-900 pb-32 relative">
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 mb-6 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold">{{ $pkl->siswa->nama }}</h2>
            <p class="text-xs text-slate-500 uppercase">{{ $pkl->siswa->kelas }} • {{ $pkl->siswa->jurusan }}</p>
        </div>

        <div class="space-y-6">
            @forelse($logbooks as $log)
                <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-6 border border-slate-100 shadow-sm relative">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs font-bold text-primary uppercase">
                                {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('l, d F Y') }}</p>
                            <span
                                class="text-[10px] px-2 py-0.5 rounded-full {{ $log->status_validasi == 'Disetujui' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $log->status_validasi }}
                            </span>
                        </div>
                    </div>

                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed italic mb-4">"{{ $log->kegiatan }}"
                    </p>

                    {{-- PERUBAHAN: Menambahkan cursor-pointer dan onclick pada gambar --}}
                    @if ($log->foto)
                        <img src="{{ asset('storage/' . $log->foto) }}"
                            alt="Dokumentasi Jurnal"
                            onclick="openImageModal('{{ asset('storage/' . $log->foto) }}')"
                            class="w-full h-40 object-cover rounded-2xl mb-4 border border-slate-100 cursor-pointer hover:opacity-90 hover:scale-[1.01] transition-all duration-300">
                    @endif

                    @if ($log->status_validasi == 'Menunggu')
                        <form action="{{ url('/pembimbing/monitoring_jurnal_harian/approve/' . $log->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full py-3 bg-green-600 text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-green-200 hover:bg-green-700 transition-colors">
                                Setujui Jurnal
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm">Belum ada riwayat jurnal.</p>
            @endforelse
        </div>
    </main>

    {{-- MODAL POPUP GAMBAR --}}
    <div id="imageModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="relative max-w-3xl w-full mx-4 flex flex-col items-center">

            {{-- Tombol Close (X) --}}
            <button onclick="closeImageModal()" class="absolute -top-12 right-0 md:-right-10 text-white/70 hover:text-white bg-black/20 hover:bg-black/50 p-2 rounded-full transition-all">
                <span class="material-symbols-outlined text-3xl block">close</span>
            </button>

            {{-- Tempat Gambar --}}
            <img id="modalImage" src="" alt="Dokumentasi Full" class="max-h-[85vh] w-auto rounded-xl shadow-2xl object-contain scale-95 transition-transform duration-300">
        </div>
    </div>

    {{-- SCRIPT UNTUK KONTROL MODAL --}}
    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');

        function openImageModal(imageSrc) {
            modalImg.src = imageSrc;

            // Tampilkan modal
            modal.classList.remove('hidden');

            // Efek transisi muncul
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalImg.classList.remove('scale-95');
                modalImg.classList.add('scale-100');
            }, 10);
        }

        function closeImageModal() {
            // Efek transisi menghilang
            modal.classList.add('opacity-0');
            modalImg.classList.remove('scale-100');
            modalImg.classList.add('scale-95');

            // Sembunyikan sepenuhnya setelah efek selesai
            setTimeout(() => {
                modal.classList.add('hidden');
                modalImg.src = '';
            }, 300);
        }

        // Tutup modal jika area gelap di luar gambar diklik
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Tutup modal saat tombol 'Escape' di keyboard ditekan
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeImageModal();
            }
        });
    </script>
@endsection
