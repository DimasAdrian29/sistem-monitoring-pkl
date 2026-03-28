<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        $user = auth()->user();

        // Cek role dan arahkan ke path yang sesuai
        if ($user->role === 'siswa') {
            return redirect()->intended('/siswa');
        } elseif ($user->role === 'guru_pembimbing' || $user->role === 'pembimbing_industri') {
            return redirect()->intended('/pembimbing');
        }

        // Default redirect untuk role admin ke halaman dashboard Filament
        return redirect()->intended('/admin');
    }
}
