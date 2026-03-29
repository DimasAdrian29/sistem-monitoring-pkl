<?php
namespace App\Http\Middleware;

use App\Models\PraktekKerjaLapangan;
use App\Models\Siswa;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPengajuanMagang
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'siswa') {
            // 1. CEK: Jika sedang mengakses halaman pengajuan, JANGAN jalankan middleware ini
            // Agar tidak terjadi tabrakan logika
            if ($request->is('pengajuan*')) {
                return $next($request);
            }

            $siswa = Siswa::where('user_id', $user->id)->first();

            if ($siswa) {
                // 2. CEK: Apakah id siswa ini ada di tabel praktek_kerja_lapangans?
                $sudahMagang = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->exists();

                if (! $sudahMagang) {
                    return redirect('/pengajuan');
                }
            } else {
                // Jika data profil siswa saja belum ada
                return redirect('/pengajuan');
            }
        }

        return $next($request);
    }
}
