<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\PraktekKerjaLapangan;

class CheckPengajuanMagang
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Pastikan ini hanya berlaku untuk role siswa
        if ($user && $user->role === 'siswa') {

            // ASUMSI: Tabel users berelasi dengan tabel siswas melalui kolom user_id
            $siswa = Siswa::where('user_id', $user->id)->first();

            if ($siswa) {
                // Cek apakah id siswa ini ada di tabel praktek_kerja_lapangans
                $sudahMagang = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->exists();

                if (!$sudahMagang) {
                    // Jika belum ada data magang, paksa ke halaman pengajuan
                    return redirect('/pengajuan');
                }
            } else {
                // Jika data profil siswa di tabel 'siswas' belum ada sama sekali
                // Lemparkan juga ke pengajuan (atau halaman lengkapi profil jika ada)
                return redirect('/pengajuan');
            }
        }

        return $next($request);
    }
}
