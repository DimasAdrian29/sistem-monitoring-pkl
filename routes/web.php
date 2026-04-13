<?php
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\MonitoringJurnalController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini di-import jika belum ada
use Illuminate\Support\Facades\Route;

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
        // Di dalam routes/web.php

        Route::get('/pengajuan', function () {
            // Mencari data siswa berdasarkan user yang sedang login
            $siswa = \App\Models\Siswa::where('user_id', auth()->id())->first();

            return view('pengajuan.index', [
                'siswa' => $siswa,
            ]);
        });
        Route::get('/pengajuan/form_pengajuan', [PengajuanController::class, 'index']);
        Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::delete('/pengajuan/reset', [PengajuanController::class, 'reset'])->name('pengajuan.reset');
        Route::get('/pengajuan/informasi_pkl', function () {
            return view('pengajuan.informasi_pkl');
        });
        Route::get('/pengajuan/peraturan_pkl', function () {
            return view('pengajuan.peraturan_pkl');
        });

        // 2. ROUTE DASHBOARD SISWA (Hanya bisa diakses jika sudah ada di tabel PKL)
        Route::middleware(['cek.magang'])->group(function () {
            // Gunakan Controller lagi
            Route::get('/siswa', [App\Http\Controllers\SiswaController::class, 'index']);
            // Memanggil class AbsensiController dan jalankan fungsi index di dalamnya
            Route::get('/siswa/absensi', [AbsensiController::class, 'index']);
            // MENJADI:
            Route::get('/siswa/absensi/form_absensi', [App\Http\Controllers\AbsensiController::class, 'formAbsensi']);
            // Di dalam middleware cek.magang
            Route::get('/siswa/jurnal_harian', [SiswaController::class, 'jurnalIndex']);
            Route::get('/siswa/jurnal_harian/form_jurnal_harian', [SiswaController::class, 'jurnalCreate']);
            Route::post('/siswa/jurnal_harian/store', [SiswaController::class, 'jurnalStore'])->name('siswa.jurnal.store');
            Route::get('/siswa/forum_diskusi', [App\Http\Controllers\ForumController::class, 'indexSiswa']);
        });

    });

    // ==========================================
    // AREA KHUSUS PEMBIMBING (Guru & Industri)
    // ==========================================
    Route::middleware(['role:guru_pembimbing,pembimbing_industri'])->group(function () {
        Route::get('/pembimbing', [App\Http\Controllers\PembimbingController::class, 'index']);
        Route::get('/pembimbing/forum_diskusi', [App\Http\Controllers\ForumController::class, 'indexPembimbing']);
        // UBAH ROUTE NILAI MENJADI SEPERTI INI:
        Route::get('/pembimbing/input_nilai', [NilaiController::class, 'index']);
        Route::get('/pembimbing/input_nilai/form_nilai/{id}', [NilaiController::class, 'edit']);
        Route::post('/pembimbing/input_nilai/store/{id}', [NilaiController::class, 'store'])->name('pembimbing.nilai.store');
        Route::get('/pembimbing/monitoring_absensi', [App\Http\Controllers\MonitoringAbsensiController::class, 'index']);
        Route::post('/pembimbing/monitoring_absensi/validasi/{id}', [App\Http\Controllers\MonitoringAbsensiController::class, 'validasiIzin']);
        Route::get('/pembimbing/monitoring_absensi/detail_siswa/{id}', [App\Http\Controllers\MonitoringAbsensiController::class, 'detailSiswa']);
        Route::get('/pembimbing/monitoring_jurnal_harian', [MonitoringJurnalController::class, 'index']);
        Route::get('/pembimbing/monitoring_jurnal_harian/detail/{id}', [MonitoringJurnalController::class, 'detail']);
        Route::post('/pembimbing/monitoring_jurnal_harian/approve/{id}', [MonitoringJurnalController::class, 'approve']);
    });

});
