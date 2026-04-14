<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\PraktekKerjaLapangan;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Ambil data PKL tanpa filter status 'Aktif' agar konsisten
        $pkl = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->first();

        if (! $pkl) {
            return redirect('/pengajuan');
        }

        $date         = $request->query('month') ? Carbon::parse($request->query('month')) : Carbon::now();
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth   = $date->copy()->endOfMonth();

        $absensiBulanIni = Absensi::where('praktek_kerja_lapangan_id', $pkl->id)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get()
            ->keyBy('tanggal');

        $rekap = [
            'Hadir' => Absensi::where('praktek_kerja_lapangan_id', $pkl->id)->where('status_kehadiran', 'Hadir')->count(),
            'Izin'  => Absensi::where('praktek_kerja_lapangan_id', $pkl->id)->whereIn('status_kehadiran', ['Izin', 'Sakit'])->count(),
            'Alpha' => Absensi::where('praktek_kerja_lapangan_id', $pkl->id)->where('status_kehadiran', 'Alpa')->count(),
        ];

        $sudahAbsenHariIni = Absensi::where('praktek_kerja_lapangan_id', $pkl->id)
            ->whereDate('tanggal', Carbon::today())
            ->exists();

        return view('siswa.absensi', [
            'date'        => $date,
            'absensi'     => $absensiBulanIni,
            'rekap'       => $rekap,
            'sudahAbsen'  => $sudahAbsenHariIni,
            'daysInMonth' => $date->daysInMonth,
            'monthName'   => $date->translatedFormat('F Y'),
            'prevMonth'   => $date->copy()->subMonth()->format('Y-m'),
            'nextMonth'   => $date->copy()->addMonth()->format('Y-m'),
        ]);
    }

   
    public function formAbsensi()
    {
        $user  = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        $pkl   = PraktekKerjaLapangan::with('industri')
            ->where('siswa_id', $siswa->id)
            ->first();

        if (! $pkl || ! $pkl->industri) {
            return redirect('/pengajuan')->with('error', 'Data penempatan PKL atau industri belum diatur.');
        }

        // Cast ke float agar tidak jadi string di JS
        $pkl->industri->latitude  = (float) $pkl->industri->latitude;
        $pkl->industri->longitude = (float) $pkl->industri->longitude;

        return view('siswa.form_absensi', compact('pkl'));
    }
    public function storeAbsensi(Request $request)
    {
        $user  = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        $pkl   = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->first();

        $request->validate([
            'status_kehadiran' => 'required',
            'latitude'         => 'required_if:status_kehadiran,Hadir',
            'longitude'        => 'required_if:status_kehadiran,Hadir',
        ]);

        Absensi::create([
            'praktek_kerja_lapangan_id' => $pkl->id,
            'pembimbing_industri_id'    => $pkl->pembimbing_industri_id,
            'tanggal'                   => now(),
            'jam_masuk'                 => now()->format('H:i:s'),
            'status_kehadiran'          => $request->status_kehadiran,
            'latitude'                  => $request->latitude,
            'longitude'                 => $request->longitude,
            'jarak_ke_industri'         => $request->jarak,
            'status_validasi'           => 'Menunggu',
        ]);

        return redirect('/siswa/absensi')->with('success', 'Presensi berhasil dikirim!');
    }

}
