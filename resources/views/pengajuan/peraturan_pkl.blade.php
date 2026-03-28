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
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Pedoman Siswa Magang</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 max-w-xs mx-auto leading-relaxed">
                Harap baca dan pahami seluruh tata tertib berikut sebelum memulai praktek kerja di industri.
            </p>
        </div>

        <main class="flex-1 p-4 sm:p-8 pb-32">
            <div class="max-w-3xl mx-auto space-y-4">

                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-xl">schedule</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Kedisiplinan & Waktu</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Siswa wajib hadir 15 menit sebelum jam kerja industri dimulai.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Mengisi absensi kehadiran setiap hari melalui sistem monitoring ini.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            Apabila berhalangan hadir, wajib melampirkan surat izin/sakit yang sah.
                        </li>
                    </ul>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-600">
                            <span class="material-symbols-outlined text-xl">checkroom</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Etika & Seragam</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500 mt-1.5 shrink-0"></span>
                            Wajib mengenakan seragam sekolah atau seragam yang ditentukan oleh industri.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500 mt-1.5 shrink-0"></span>
                            Menjaga nama baik sekolah dan berperilaku sopan kepada seluruh staf industri.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500 mt-1.5 shrink-0"></span>
                            Dilarang menggunakan perangkat seluler untuk keperluan pribadi di jam kerja.
                        </li>
                    </ul>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-slate-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-purple-600">
                            <span class="material-symbols-outlined text-xl">edit_note</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Pelaporan Kegiatan</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-purple-500 mt-1.5 shrink-0"></span>
                            Siswa wajib mengisi Jurnal Harian secara mendetail setiap hari kerja.
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-purple-500 mt-1.5 shrink-0"></span>
                            Laporan PKL harus diselesaikan secara bertahap selama masa magang.
                        </li>
                    </ul>
                </div>

                <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 flex gap-3">
                    <span class="material-symbols-outlined text-red-500">warning</span>
                    <p class="text-[11px] text-red-700 dark:text-red-400 leading-relaxed font-medium">
                        Pelanggaran terhadap tata tertib di atas dapat berakibat pada penarikan siswa dari tempat magang dan kegagalan mata pelajaran PKL.
                    </p>
                </div>
            </div>
        </main>

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
