<?php
namespace App\Http\Controllers;

use App\Models\PraktekKerjaLapangan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class SiswaNilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari data siswa berdasarkan user yang login
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        // Ambil data PKL beserta relasi nilai, pembimbing industri, dan guru pembimbing
        $pkl = PraktekKerjaLapangan::with(['nilai', 'industri', 'pembimbing_industri', 'guru_pembimbing'])
            ->where('siswa_id', $siswa->id)
            ->latest() // Ambil PKL terbaru
            ->first();

        // Logika Hitung Rata-rata (Hanya menghitung aspek yang sudah diisi)
        $rataRata = 0;
        if ($pkl && $pkl->nilai) {
            $aspekDinilai = [
                $pkl->nilai->aspek_soft_skills,
                $pkl->nilai->aspek_norma_k3lh,
                $pkl->nilai->aspek_kompetensi_teknis,
                $pkl->nilai->aspek_wawasan_bisnis,
                $pkl->nilai->aspek_penyusunan_laporan,
                $pkl->nilai->aspek_presentasi,
            ];

            $totalNilai  = 0;
            $jumlahAspek = 0;

            foreach ($aspekDinilai as $nilaiAspek) {
                if ($nilaiAspek !== null) {
                    $totalNilai += $nilaiAspek;
                    $jumlahAspek++;
                }
            }

            if ($jumlahAspek > 0) {
                $rataRata = round($totalNilai / $jumlahAspek);
            }
        }

        return view('siswa.nilai', compact('pkl', 'rataRata'));
    }
}
