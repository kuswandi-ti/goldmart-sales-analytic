<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda tidak bisa mengakses halaman yang dituju. Silahkan login terlebih dahulu');
        } else {
            if (Auth::user()->status_aktif == 0) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun anda tidak aktif. Silahkan hubungi admin');
            } else if (Auth::user()->approved != 1) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun anda belum aktif. Perlu approve dari admin agar akun anda bisa digunakan. Silahkan hubungi admin');
            } else if (!Auth::user()->email_verified_at) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Anda perlu mengonfirmasi akun Anda. Kami telah mengirimkan Anda kode aktivasi, silakan periksa email Anda');
            } else if (Auth::user()->getRoleNames()->isEmpty()) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Anda tidak memiliki akses masuk ke dalam sistem ini');
            }
        }

        return $next($request);
    }
}
