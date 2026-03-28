<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminPanelAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user sudah login tapi BUKAN admin, lempar ke tempat yang benar
        if ($user && $user->role !== 'admin') {

            if ($user->role === 'siswa') {
                return redirect('/siswa');
            }

            if (in_array($user->role, ['guru_pembimbing', 'pembimbing_industri'])) {
                return redirect('/pembimbing');
            }

            // Jaga-jaga jika ada role yang tidak dikenali
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
