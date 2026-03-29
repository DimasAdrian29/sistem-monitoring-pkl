<?php
namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\PengajuanMagang;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Ambil pengajuan terakhir milik siswa ini
        $pengajuan = PengajuanMagang::where('siswa_id', $siswa->id)->latest()->first();
        $industris = Industri::all();

        return view('pengajuan.form_pengajuan', compact('siswa', 'pengajuan', 'industris'));
    }

    public function store(Request $request)
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();

        $request->validate([
            'industri_id' => 'required|exists:industris,id',
            'cv'          => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('cv')->store('cv_pendaftaran', 'public');

        PengajuanMagang::create([
            'siswa_id'         => $siswa->id,
            'industri_id'      => $request->industri_id,
            'tgl_pengajuan'    => now(),
            'cv'               => $path,
            'status_pengajuan' => 'Menunggu',
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim!');
    }

    public function reset()
    {
        $siswa     = Siswa::where('user_id', Auth::id())->first();
        $pengajuan = PengajuanMagang::where('siswa_id', $siswa->id)->where('status_pengajuan', 'Ditolak')->first();

        if ($pengajuan) {
            // Hapus file CV dari storage
            Storage::disk('public')->delete($pengajuan->cv);
            // Hapus data pengajuan agar siswa bisa daftar lagi
            $pengajuan->delete();
        }

        return back();
    }
    // Tambahkan ini di App\Http\Controllers\PengajuanController.php

    public function informasi(Request $request)
    {
        $search = $request->query('search');

        // Mengambil data industri, jika ada pencarian maka difilter
        $industris = \App\Models\Industri::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%");
        })->get();

        return view('pengajuan.informasi_pkl', compact('industris'));
    }
}
