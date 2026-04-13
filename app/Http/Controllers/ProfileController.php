<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\GuruPembimbing;
use App\Models\PembimbingIndustri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 1. Menampilkan Halaman Profil
    public function index()
    {
        $user = Auth::user();
        $profileData = null;

        if ($user->role === 'siswa') {
            $profileData = Siswa::where('user_id', $user->id)->first();
        } elseif ($user->role === 'guru_pembimbing') {
            $profileData = GuruPembimbing::where('user_id', $user->id)->first();
        } elseif ($user->role === 'pembimbing_industri') {
            $profileData = PembimbingIndustri::where('user_id', $user->id)->first();
        }

        return view('profile.index', compact('user', 'profileData'));
    }

    // 2. Mengupdate Data Profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Update email/username di tabel Users
        $request->validate([
            'gmail' => 'required|email|unique:users,gmail,' . $user->id,
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $userModel = User::find($user->id);
        $userModel->gmail = $request->gmail;
        $userModel->save();

        // Update data spesifik berdasarkan Role
        if ($user->role === 'siswa') {
            Siswa::where('user_id', $user->id)->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
                'nomor_telepon_wali' => $request->nomor_telepon_wali,
            ]);
        } elseif ($user->role === 'guru_pembimbing') {
            GuruPembimbing::where('user_id', $user->id)->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
            ]);
        } elseif ($user->role === 'pembimbing_industri') {
            $request->validate(['jabatan' => 'required|string']);
            PembimbingIndustri::where('user_id', $user->id)->update([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // 3. Mengupdate Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // butuh input new_password_confirmation di form
        ]);

        $user = User::find(Auth::id());

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        // Ganti password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
