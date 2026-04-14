<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\GuruPembimbing;
use App\Models\Logbook;
use App\Models\PembimbingIndustri;
use App\Models\PraktekKerjaLapangan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $pklIds = [];

        // 1. Kumpulkan ID PKL berdasarkan Role
        if ($user->role === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            if ($siswa) {
                $pklIds = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->pluck('id')->toArray();
            }
        } elseif ($user->role === 'guru_pembimbing') {
            $gp = GuruPembimbing::where('user_id', $user->id)->first();
            if ($gp) {
                $pklIds = PraktekKerjaLapangan::where('guru_pembimbing_id', $gp->id)->pluck('id')->toArray();
            }
        } elseif ($user->role === 'pembimbing_industri') {
            $pi = PembimbingIndustri::where('user_id', $user->id)->first();
            if ($pi) {
                $pklIds = PraktekKerjaLapangan::where('pembimbing_industri_id', $pi->id)->pluck('id')->toArray();
            }
        }

        // 2. Ambil Data Absensi dan Logbook jika ada PKL
        $activities = collect();

        if (! empty($pklIds)) {
            // Ambil Absensi
            $absensis = Absensi::with('praktek_kerja_lapangan.siswa')
                ->whereIn('praktek_kerja_lapangan_id', $pklIds)
                ->get();

            // Ambil Logbook
            $logbooks = Logbook::with('praktek_kerja_lapangan.siswa')
                ->whereIn('praktek_kerja_lapangan_id', $pklIds)
                ->get();

            // 3. Format dan Gabungkan Data (Merge)
            foreach ($absensis as $absen) {
                $activities->push((object) [
                    'type'             => 'absensi',
                    'sort_date'        => $absen->created_at, // Untuk sorting
                    'tanggal'          => $absen->tanggal,
                    'siswa_nama'       => $absen->praktek_kerja_lapangan->siswa->nama ?? 'Unknown',
                    'status_kehadiran' => $absen->status_kehadiran,
                    'status_validasi'  => $absen->status_validasi,
                    'jam'              => $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '-',
                    'detail'           => 'Melakukan absensi kehadiran',
                ]);
            }

            foreach ($logbooks as $log) {
                $activities->push((object) [
                    'type'            => 'logbook',
                    'sort_date'       => $log->created_at, // Untuk sorting
                    'tanggal'         => $log->tanggal,
                    'siswa_nama'      => $log->praktek_kerja_lapangan->siswa->nama ?? 'Unknown',
                    'status_validasi' => $log->status_validasi,
                    'jam'             => $log->created_at->format('H:i'), // Jam input jurnal
                    'detail'          => \Illuminate\Support\Str::limit($log->kegiatan, 50, '...'),
                ]);
            }

            // 4. Urutkan dari yang terbaru (Descending)
            $activities = $activities->sortByDesc('sort_date')->values();
        }

        $role = $user->role;

        return view('aktivitas.index', compact('activities', 'role'));
    }
}
