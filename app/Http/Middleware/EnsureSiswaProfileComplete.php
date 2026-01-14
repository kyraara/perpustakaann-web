<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiswaProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Only check for siswa role
        if ($user && $user->role === 'siswa') {
            // Check if profile is incomplete
            if (empty($user->nisn) || empty($user->kelas) || empty($user->jenis_kelamin)) {
                // Don't redirect if already on complete-profile page or logout
                if (!$request->routeIs('siswa.complete-profile') && !$request->routeIs('siswa.complete-profile.update') && !$request->routeIs('logout')) {
                    return redirect()->route('siswa.complete-profile')
                        ->with('info', 'Silakan lengkapi data profil Anda terlebih dahulu.');
                }
            }
        }
        
        return $next($request);
    }
}
