<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\GuruPembimbing;
use App\Models\PembimbingIndustri;
use App\Models\PraktekKerjaLapangan;
use Illuminate\Support\Facades\Auth;

class PembimbingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Siapkan variabel kosong
        $title                = '';
        $nama                 = '';
        $nama_tempat          = '';
        $jumlah_siswa         = 0;
        $jumlah_izin_menunggu = 0;

        if ($user->role === 'pembimbing_industri') {
            $profil = PembimbingIndustri::with('industri')->where('user_id', $user->id)->first();

            $title       = 'Pembimbing Industri';
            $nama        = $profil->nama;
            $nama_tempat = $profil->industri->nama;

            // Hitung siswa yang dibimbing oleh mentor ini
            $jumlah_siswa = PraktekKerjaLapangan::where('pembimbing_industri_id', $profil->id)->count();

            // Hitung izin/absensi yang masih 'Menunggu' validasi
            $jumlah_izin_menunggu = Absensi::where('pembimbing_industri_id', $profil->id)
                ->where('status_validasi', 'Menunggu')
                ->count();

        } elseif ($user->role === 'guru_pembimbing') {
            $profil = GuruPembimbing::where('user_id', $user->id)->first();

            $title       = 'Guru Pembimbing';
            $nama        = $profil->nama;
            $nama_tempat = 'SMKN 5 Pekanbaru'; // Default untuk guru

            // Hitung siswa yang dibimbing oleh guru ini
            $jumlah_siswa = PraktekKerjaLapangan::where('guru_pembimbing_id', $profil->id)->count();

            // Karena tabel absensi tidak punya guru_pembimbing_id langsung,
            // kita cari absensi milik PKL yang dibimbing oleh guru ini
            $jumlah_izin_menunggu = Absensi::whereHas('praktek_kerja_lapangan', function ($query) use ($profil) {
                $query->where('guru_pembimbing_id', $profil->id);
            })->where('status_validasi', 'Menunggu')->count();
        }

        return view('pembimbing.index', compact(
            'user', 'title', 'nama', 'nama_tempat', 'jumlah_siswa', 'jumlah_izin_menunggu'
        ));
    }
}
