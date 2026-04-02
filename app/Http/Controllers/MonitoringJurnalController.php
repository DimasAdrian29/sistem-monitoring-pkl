<?php
namespace App\Http\Controllers;

use App\Models\GuruPembimbing;
use App\Models\Logbook;
use App\Models\PembimbingIndustri;
use App\Models\PraktekKerjaLapangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringJurnalController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $today = Carbon::today();

        // Identifikasi Pembimbing
        if ($user->role === 'pembimbing_industri') {
            $pembimbing = PembimbingIndustri::where('user_id', $user->id)->first();
            $query      = PraktekKerjaLapangan::where('pembimbing_industri_id', $pembimbing->id);
        } else {
            $guru  = GuruPembimbing::where('user_id', $user->id)->first();
            $query = PraktekKerjaLapangan::where('guru_pembimbing_id', $guru->id);
        }

        $daftarPkl = $query->with(['siswa', 'logbooks' => function ($q) use ($today) {
            $q->whereDate('tanggal', $today);
        }])->get();

        // Statistik
        $pklIds      = $daftarPkl->pluck('id');
        $totalJurnal = Logbook::whereIn('praktek_kerja_lapangan_id', $pklIds)->count();
        $jurnalBaru  = Logbook::whereIn('praktek_kerja_lapangan_id', $pklIds)
            ->whereDate('tanggal', $today)->count();

        return view('pembimbing.monitoring_jurnal_harian', compact('daftarPkl', 'totalJurnal', 'jurnalBaru', 'today'));
    }

    public function detail($id)
    {
        $pkl      = PraktekKerjaLapangan::with('siswa')->findOrFail($id);
        $logbooks = Logbook::where('praktek_kerja_lapangan_id', $id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pembimbing.detail_jurnal_harian_siswa', compact('pkl', 'logbooks'));
    }

    public function approve($id)
    {
        Logbook::findOrFail($id)->update(['status_validasi' => 'Disetujui']);
        return back()->with('success', 'Jurnal berhasil disetujui');
    }
}
