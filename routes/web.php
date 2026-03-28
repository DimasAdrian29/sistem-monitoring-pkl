<?php

use Illuminate\Support\Facades\Route;

// 1. Ubah halaman pertama (index) langsung ke halaman login filament
Route::get('/', function () {
    return redirect('/admin/login');
});

// 2. Bungkus semua route aplikasi dengan middleware auth
// agar halaman ini tidak bisa diakses jika belum login
Route::middleware(['auth'])->group(function () {

    // --- ROUTE PENGAJUAN ---
    Route::get('/pengajuan', function () {
        return view('pengajuan.index');
    });
    Route::get('/pengajuan/form_pengajuan', function () {
        return view('pengajuan.form_pengajuan');
    });
    Route::get('/pengajuan/informasi_pkl', function () {
        return view('pengajuan.informasi_pkl');
    });
    Route::get('/pengajuan/peraturan_pkl', function () {
        return view('pengajuan.peraturan_pkl');
    });

    // --- ROUTE PEMBIMBING ---
    Route::get('/pembimbing', function () {
        return view('pembimbing.index');
    });
    Route::get('/pembimbing/forum_diskusi', function () {
        return view('pembimbing.forum_diskusi');
    });
    Route::get('/pembimbing/input_nilai', function () {
        return view('pembimbing.input_nilai');
    });
    Route::get('/pembimbing/input_nilai/form_nilai', function () {
        return view('pembimbing.form_nilai');
    });
    Route::get('/pembimbing/monitoring_absensi', function () {
        return view('pembimbing.monitoring_absensi');
    });
    Route::get('/pembimbing/monitoring_absensi/detail_siswa', function () {
        return view('pembimbing.detail_absensi_siswa');
    });
    Route::get('/pembimbing/monitoring_jurnal_harian', function () {
        return view('pembimbing.monitoring_jurnal_harian');
    });
    Route::get('/pembimbing/monitoring_jurnal_harian/detail', function () {
        return view('pembimbing.detail_jurnal_harian_siswa');
    });

    // --- ROUTE SISWA ---
    Route::get('/siswa', function () {
        return view('siswa.index');
    });
    Route::get('/siswa/absensi', function () {
        return view('siswa.absensi');
    });
    Route::get('/siswa/absensi/form_absensi', function () {
        return view('siswa.form_absensi');
    });
    Route::get('/siswa/jurnal_harian', function () {
        return view('siswa.jurnal_harian');
    });
    Route::get('/siswa/jurnal_harian/form_jurnal_harian', function () {
        return view('siswa.form_jurnal_harian');
    });
    Route::get('/siswa/forum_diskusi', function () {
        return view('siswa.forum_diskusi');
    });

});
