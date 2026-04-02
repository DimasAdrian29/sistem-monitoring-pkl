@extends('layouts.siswa', ['hideNav' => true])


@section('content')
    @include('siswa.partials.header_menu', ['title' => 'Forum Diskusi', 'backUrl' => url('/siswa')])

    {{-- PANGGIL KOMPONEN REALTIME DI SINI --}}
    @livewire('chat-forum')

@endsection
