<?php
namespace App\Http\Controllers;

use App\Models\GuruPembimbing;
use App\Models\Nilai;
use App\Models\PembimbingIndustri;
use App\Models\PraktekKerjaLapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        $user = Auth::user();
        $pkls = collect();

        // Cek jika yang login adalah Pembimbing Industri
        if ($user->hasRole('pembimbing_industri')) {
            $pi = PembimbingIndustri::where('user_id', $user->id)->first();
            if ($pi) {
                // Ambil data PKL yang dibimbing oleh Pembimbing Industri ini
                $pkls = PraktekKerjaLapangan::with(['siswa', 'nilai'])
                    ->where('pembimbing_industri_id', $pi->id)
                    ->get();
            }
        }
        // Cek jika yang login adalah Guru Pembimbing
        elseif ($user->hasRole('guru_pembimbing')) {
            $gp = GuruPembimbing::where('user_id', $user->id)->first();
            if ($gp) {
                // Ambil data PKL yang dibimbing oleh Guru Pembimbing ini
                $pkls = PraktekKerjaLapangan::with(['siswa', 'nilai'])
                    ->where('guru_pembimbing_id', $gp->id)
                    ->get();
            }
        }

        return view('pembimbing.input_nilai', compact('pkls'));
    }

    // Menampilkan form input nilai
    public function edit($id)
    {
        $pkl  = PraktekKerjaLapangan::with(['siswa', 'nilai'])->findOrFail($id);
        $user = Auth::user();
        $role = $user->hasRole('pembimbing_industri') ? 'industri' : 'guru';

        // Jika nilai belum ada, buat instance kosong agar tidak error di view
        $nilai = $pkl->nilai ?? new Nilai();

        return view('pembimbing.form_nilai', compact('pkl', 'nilai', 'role'));
    }

    // Menyimpan atau mengupdate nilai
    public function store(Request $request, $id)
    {
        $pkl  = PraktekKerjaLapangan::findOrFail($id);
        $user = Auth::user();

        // Cari data nilai berdasarkan PKL ID, jika tidak ada maka buat baru
        $nilai = Nilai::firstOrNew(['praktek_kerja_lapangan_id' => $pkl->id]);

        if ($user->hasRole('pembimbing_industri')) {
            $pi                            = PembimbingIndustri::where('user_id', $user->id)->first();
            $nilai->pembimbing_industri_id = $pi->id;

            $nilai->aspek_soft_skills           = $request->aspek_soft_skills;
            $nilai->aspek_norma_k3lh            = $request->aspek_norma_k3lh;
            $nilai->aspek_kompetensi_teknis     = $request->aspek_kompetensi_teknis;
            $nilai->aspek_wawasan_bisnis        = $request->aspek_wawasan_bisnis;
            $nilai->catatan_pembimbing_industri = $request->catatan_pembimbing_industri;
        } elseif ($user->hasRole('guru_pembimbing')) {
            $gp                        = GuruPembimbing::where('user_id', $user->id)->first();
            $nilai->guru_pembimbing_id = $gp->id;

            $nilai->aspek_penyusunan_laporan = $request->aspek_penyusunan_laporan;
            $nilai->aspek_presentasi         = $request->aspek_presentasi;
            $nilai->catatan_guru_pembimbing  = $request->catatan_guru_pembimbing;
        }

        $nilai->save();

        return redirect('/pembimbing/input_nilai')->with('success', 'Nilai berhasil disimpan!');
    }
}
