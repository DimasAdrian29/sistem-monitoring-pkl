<?php
namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\PraktekKerjaLapangan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class SiswaController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();

        // Kita ambil data PKL tanpa mempedulikan status 'Aktif' dulu untuk tes
        $pkl = \App\Models\PraktekKerjaLapangan::with('industri')
            ->where('siswa_id', $siswa->id)
            ->first();

        $recentAbsensi = \App\Models\Absensi::where('praktek_kerja_lapangan_id', $pkl->id ?? 0)
            ->where('tanggal', '>=', \Carbon\Carbon::now()->subDays(7))
            ->get()
            ->map(function ($item) {
                $item->activity_type = 'absensi';
                return $item;
            });

        $recentLogbook = \App\Models\Logbook::where('praktek_kerja_lapangan_id', $pkl->id ?? 0)
            ->where('tanggal', '>=', \Carbon\Carbon::now()->subDays(7))
            ->get()
            ->map(function ($item) {
                $item->activity_type = 'logbook';
                return $item;
            });

        $activities = $recentAbsensi->concat($recentLogbook)->sortByDesc('created_at');

        return view('siswa.index', compact('siswa', 'pkl', 'activities'));
    }

    public function jurnalIndex()
    {
        $user  = Auth::user();
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
        $pkl   = \App\Models\PraktekKerjaLapangan::where('siswa_id', $siswa->id)->first();

        // 1. Ambil riwayat jurnal dengan PAGINATION (10 per halaman)
        $logbooks = \App\Models\Logbook::where('praktek_kerja_lapangan_id', $pkl->id)
            ->latest('tanggal')
            ->paginate(10); // PERUBAHAN DI SINI: get() diganti menjadi paginate(10)

        // 2. Cek apakah hari ini sudah mengisi jurnal
        $hasFilledToday = \App\Models\Logbook::where('praktek_kerja_lapangan_id', $pkl->id)
            ->whereDate('tanggal', \Carbon\Carbon::today())
            ->exists();

        return view('siswa.jurnal_harian', compact('logbooks', 'hasFilledToday'));
    }

    public function jurnalCreate()
    {
        $user  = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        $pkl   = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->first();

        $hasFilledToday = Logbook::where('praktek_kerja_lapangan_id', $pkl->id)
            ->whereDate('tanggal', now())
            ->exists();

        if ($hasFilledToday) {
            return redirect('/siswa/jurnal_harian')->with('error', 'Anda sudah mengisi jurnal hari ini.');
        }

        return view('siswa.form_jurnal_harian');
    }

    public function jurnalStore(Request $request)
    {
        $user  = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        $pkl   = PraktekKerjaLapangan::where('siswa_id', $siswa->id)->first();

        $request->validate([
            'kegiatan' => 'required|string|min:10',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:5048', // Max 5MB
        ]);

        $namaFile = null;

        if ($request->hasFile('foto')) {
            $image    = $request->file('foto');
            $namaFile = time() . '.' . $image->getClientOriginalExtension();

            // PROSES KOMPRESI 50%
            $img     = Image::read($image->getRealPath());
            $encoded = $img->toJpeg(50); // Kompresi kualitas ke 50%

            // Simpan ke storage/app/public/logbooks
            Storage::disk('public')->put('logbooks/' . $namaFile, $encoded);
        }

        Logbook::create([
            'praktek_kerja_lapangan_id' => $pkl->id,
            'tanggal'                   => now(),
            'kegiatan'                  => $request->kegiatan,
            'foto'                      => $namaFile ? 'logbooks/' . $namaFile : null,
            'status_validasi'           => 'Menunggu',
        ]);

        return redirect('/siswa/jurnal_harian')->with('success', 'Jurnal harian berhasil disimpan!');
    }
}
