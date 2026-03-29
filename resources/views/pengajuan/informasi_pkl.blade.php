@extends('layouts.siswa', ['hideNav' => true])

@section('title', 'Informasi Mitra PKL - SMKN 5 Pekanbaru')

@section('content')
    @include('siswa.partials.header_menu', [
        'title' => 'Informasi Mitra Industri',
        'backUrl' => url('/pengajuan')
    ])

    <div class="flex flex-col min-h-[calc(100vh-64px)] bg-slate-50 dark:bg-gray-900">
        {{-- Panggil Komponen Livewire di sini --}}
        @livewire('informasi-industri')

        <div class="p-6 text-center">
            <p class="text-[10px] text-slate-400 uppercase tracking-widest leading-relaxed">
                Daftar mitra di atas adalah industri yang sudah memiliki MoU aktif dengan SMKN 5 Pekanbaru.
            </p>
        </div>
    </div>
@endsection
