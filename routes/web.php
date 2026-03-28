<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // Pastikan ini di-import jika belum ada
use Illuminate\Support\Facades\Auth;
// Redirect root ke login filament
Route::get('/', function () {
    return redirect('/admin/login');
});

// Bungkus semua dengan middleware auth agar harus login
Route::middleware(['auth'])->group(function () {
// ==========================================
    // ROUTE LOGOUT CUSTOM
    // ==========================================
    Route::post('/logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    })->name('logout');
   // ==========================================
    // AREA KHUSUS SISWA
    // ==========================================
    Route::middleware(['role:siswa'])->group(function () {

        // 1. ROUTE PENGAJUAN (Tidak perlu dicek magangnya, karena justru ini tujuannya)
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

        // 2. ROUTE DASHBOARD SISWA (Hanya bisa diakses jika sudah ada di tabel PKL)
        Route::middleware(['cek.magang'])->group(function () {
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

    });

    // ==========================================
    // AREA KHUSUS PEMBIMBING (Guru & Industri)
    // ==========================================
    Route::middleware(['role:guru_pembimbing,pembimbing_industri'])->group(function () {
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
    });

});
