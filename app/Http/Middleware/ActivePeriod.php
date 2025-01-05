<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActivePeriod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (empty(activePeriod())) {
                return redirect()->route('admin.dashboard.index')
                    ->with('error', 'Tidak ada periode aktif. Silahkan mengaktifkan salah satu periode terlebih dahulu');
            }
        }

        return $next($request);
    }
}
