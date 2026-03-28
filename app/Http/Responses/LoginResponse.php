<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as Responsable;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements Responsable
{
    public function toResponse($request)
    {
        $user = Auth::user();

        // Jika dia Admin, biarkan masuk ke dashboard Filament (/admin)
        if ($user->role === 'admin') {
            return redirect()->intended('/admin');
        }

        // Jika Siswa atau Pembimbing, tendang keluar ke rute utama '/'
        // agar diproses oleh RedirectController kamu
        return redirect('/');
    }
}
