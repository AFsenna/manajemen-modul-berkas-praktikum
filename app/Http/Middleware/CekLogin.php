<?php

namespace App\Http\Middleware;

use App\Models\Mahasiswa;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $key => $row) {
            if (Auth::guard('mahasiswa')->user()) {
                if ($row == "aslab") {
                    $cek = false;
                    foreach ($roles as $key => $aslab) {
                        //1 = aslab
                        if (Auth::guard('mahasiswa')->user()->role_id == 1) {
                            $cek = true;
                        }
                    }
                }

                if ($row == "praktikan") {
                    $cek = false;
                    foreach ($roles as $key => $aslab) {
                        //2 = praktikan
                        if (Auth::guard('mahasiswa')->user()->role_id == 2) {
                            $cek = true;
                        }
                    }
                }

                if ($cek) {
                    return $next($request);
                } else {
                    abort(403, 'Anda tidak diberikan ijin akses halaman ini');
                }
            }
        }

        foreach ($roles as $row) {
            if ($row == 'aslab' || $row == 'praktikan') {
                return redirect()->route('auth.login');
            }
        }
    }
}
