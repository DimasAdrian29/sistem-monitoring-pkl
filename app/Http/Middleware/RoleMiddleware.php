<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        $user = Auth::user();

        // Jika role user saat ini tidak ada di dalam daftar role yang diizinkan untuk route tersebut
        if (!in_array($user->role, $roles)) {

            // Redirect otomatis kembali ke 'rumahnya' masing-masing agar aman
            if ($user->role === 'admin') {
                return redirect('/admin');
            } elseif ($user->role === 'siswa') {
                return redirect('/siswa');
            } elseif (in_array($user->role, ['guru_pembimbing', 'pembimbing_industri'])) {
                return redirect('/pembimbing');
            }

            // Fallback jika role tidak dikenali
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
