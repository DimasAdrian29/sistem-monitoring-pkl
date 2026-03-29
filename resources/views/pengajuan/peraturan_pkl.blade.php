@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Peraturan & Tata Tertib PKL - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Peraturan PKL',
        'backUrl' => url('/pengajuan')
    ])

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">
        <div class="p-6 text-center bg-white dark:bg-gray-800 border-b border-slate-100 dark:border-gray-700">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 mb-4">
                <span class="material-symbols-outlined text-4xl">gavel</span>
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Pedoman Siswa Magang (PKL)</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 max-w-xs mx-auto leading-relaxed">
                Harap baca dan pahami seluruh tata tertib, kewajiban, serta larangan sebelum memulai Praktek Kerja Lapangan di industri.
            </p>
        </div>

        <main class="flex-1 p-4 sm:p-8 pb-32">
            <div class="max-w-3xl mx-auto space-y-4">

                {{-- Informasi Umum PKL --}}

                {{-- Kewajiban Peserta PKL --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-xl">assignment</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Kewajiban Peserta PKL</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Hadir 15 menit sebelum jam kerja dimulai, bersikap sopan, jujur, bertanggung jawab, kreatif, dan inisiatif.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Mengenakan seragam sesuai ketentuan sekolah atau dunia kerja.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Memberi salam saat datang dan pamit saat pulang.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Segera berkonsultasi dengan pembimbing lapangan jika mengalami kesulitan.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Mentaati aturan penggunaan peralatan dan bahan selama PKL.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Melaporkan kerusakan atau kesalahan saat PKL kepada yang berwenang.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Membersihkan dan merapikan peralatan setelah praktik.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Memberitahu pembimbing/pimpinan jika berhalangan hadir atau meninggalkan tempat PKL.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Memberitahu panitia PKL jika sakit/izin minimal 1 hari sebelumnya.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Mengisi jurnal harian, absensi (dengan tanda tangan pembimbing), membuat laporan dan mempresentasikannya.
                        </li>
                    </ul>
                </div>

                {{-- Larangan Peserta PKL --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                            <span class="material-symbols-outlined text-xl">block</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Larangan Selama PKL</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Merokok di area praktik.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Menerima tamu pribadi selama jam kerja.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Menggunakan peralatan perusahaan tanpa izin.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Menggunakan HP saat bekerja (kecuali keperluan kerja).
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            <span>Mengambil barang milik tempat PKL (sanksi: dikeluarkan dari sekolah & mengganti barang).</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Peserta putra: rambut panjang, mengecat rambut, aksesori berlebihan.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Pindah tempat PKL tanpa seizin perusahaan dan panitia.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Merusak barang/alat karena kelalaian (sanksi: dikeluarkan & mengganti).
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            Khusus siswi: perhiasan mencolok, rias berlebihan, rok mini/celana ketat, sepatu hak tinggi.
                        </li>
                    </ul>
                </div>

                {{-- Sanksi Pelanggaran --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-600">
                            <span class="material-symbols-outlined text-xl">report</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Sanksi Pelanggaran</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                            Peringatan lisan.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                            Peringatan tertulis.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                            Ditarik kembali ke sekolah (pemutusan PKL).
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                            Gagal PKL (dinyatakan tidak lulus program PKL).
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                            Tidak naik kelas / tidak lulus (jika gagal PKL).
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                            Dikembalikan ke orang tua (skorsing/putus sekolah).
                        </li>
                    </ul>
                </div>

                {{-- Nilai Karakter --}}
                <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-900/20 flex gap-3">
                    <span class="material-symbols-outlined text-green-600">stars</span>
                    <div class="text-[11px] text-green-700 dark:text-green-400 leading-relaxed font-medium">
                        <span class="font-bold">Nilai karakter yang dikembangkan:</span> Jujur, disiplin, kerja keras, kreatif, mandiri, rasa ingin tahu, menghargai prestasi, komunikatif, peduli lingkungan, peduli sosial, dan bertanggung jawab. Integrasikan nilai-nilai ini selama PKL.
                    </div>
                </div>

                {{-- Catatan penting --}}
                <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 flex gap-3">
                    <span class="material-symbols-outlined text-red-500">warning</span>
                    <p class="text-[11px] text-red-700 dark:text-red-400 leading-relaxed font-medium">
                        Pelanggaran terhadap tata tertib di atas dapat berakibat pada penarikan siswa dari tempat magang, kegagalan mata pelajaran PKL, hingga dikembalikan ke orang tua.
                    </p>
                </div>
            </div>
        </main>
        <br><br><br>
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-t border-slate-100 dark:border-gray-700 flex flex-col items-center">
            <div class="max-w-3xl w-full">
                <a href="{{ url('/pengajuan/form_pengajuan') }}" class="w-full flex items-center justify-center gap-2 bg-primary py-4 rounded-2xl text-white font-bold text-sm shadow-lg shadow-primary/30 hover:bg-blue-600 transition-all active:scale-[0.98]">
                    <span>Saya Mengerti & Siap Mendaftar</span>
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                </a>
            </div>
        </div>
    </div>
@endsection
