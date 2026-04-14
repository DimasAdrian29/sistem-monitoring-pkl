<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\GuruPembimbing;
use App\Models\PembimbingIndustri;
use App\Models\PraktekKerjaLapangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringAbsensiController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $today = Carbon::today();

        // 1. Tentukan ID Pembimbing berdasarkan Role
        $pembimbingIndustriId = null;
        $guruPembimbingId     = null;

        if ($user->role === 'pembimbing_industri') {
            $pembimbing           = PembimbingIndustri::where('user_id', $user->id)->first();
            $pembimbingIndustriId = $pembimbing->id;
        } elseif ($user->role === 'guru_pembimbing') {
            $guru             = GuruPembimbing::where('user_id', $user->id)->first();
            $guruPembimbingId = $guru->id;
        }

        // 2. Ambil data PKL (Siswa Bimbingan) yang aktif
        $pklQuery = PraktekKerjaLapangan::with(['siswa', 'absensis' => function ($query) use ($today) {
            $query->whereDate('tanggal', $today);
        }])->where('status_magang', 'Aktif');

        if ($pembimbingIndustriId) {
            $pklQuery->where('pembimbing_industri_id', $pembimbingIndustriId);
        } else {
            $pklQuery->where('guru_pembimbing_id', $guruPembimbingId);
        }

        $daftarPkl = $pklQuery->get();
        $pklIds    = $daftarPkl->pluck('id');

        // 3. AUTO-VALIDASI: Ubah semua 'Hadir' hari ini menjadi 'Diterima'
        Absensi::whereIn('praktek_kerja_lapangan_id', $pklIds)
            ->whereDate('tanggal', $today)
            ->where('status_kehadiran', 'Hadir')
            ->where('status_validasi', 'Menunggu')
            ->update(['status_validasi' => 'Disetujui']);

        // Refresh data absensi setelah auto-validasi
        // (Agar data yang dikirim ke view sudah berstatus 'Diterima')
        $daftarPkl = $pklQuery->get();

        // 4. Hitung Statistik Hari Ini
        $totalSiswa = $daftarPkl->count();
        $sudahAbsen = 0;
        $belumAbsen = 0;
        $dataSiswa  = [];

        foreach ($daftarPkl as $pkl) {
            $absenHariIni = $pkl->absensis->first();

            if ($absenHariIni) {
                $sudahAbsen++;
            } else {
                $belumAbsen++;
            }

            $dataSiswa[] = [
                'pkl'     => $pkl,
                'siswa'   => $pkl->siswa,
                'absensi' => $absenHariIni,
            ];
        }

        return view('pembimbing.monitoring_absensi', compact(
            'today', 'totalSiswa', 'sudahAbsen', 'belumAbsen', 'dataSiswa'
        ));
    }

    // Fungsi untuk memvalidasi Izin/Sakit
    public function validasiIzin($id)
    {
        try {
            $absen = \App\Models\Absensi::findOrFail($id);
            $absen->update([
                'status_validasi' => 'Disetujui',
            ]);

            // JANGAN PAKAI REDIRECT! Gunakan ini:
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
            ]);

        } catch (\Exception $e) {
            // Jika ada error (misal ID tidak ketemu), kirim pesan error JSON
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // Fungsi untuk menampilkan detail absensi satu siswa
    public function detailSiswa($id)
    {
        // 1. Ambil data PKL beserta relasi Siswa dan Industri
        $pkl = PraktekKerjaLapangan::with(['siswa', 'industri'])->findOrFail($id);

        // 2. Ambil seluruh riwayat absensi siswa ini, urutkan dari yang terbaru
        $absensis = Absensi::where('praktek_kerja_lapangan_id', $pkl->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pembimbing.detail_absensi_siswa', compact('pkl', 'absensis'));
    }
}
