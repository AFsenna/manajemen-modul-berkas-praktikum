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
    public function handle(Request $request, Closure $next, ...$role)
    {

        if (!is_null(Auth::user())) {
            if (in_array(Auth::user()->role, $role)) {
                return $next($request);
            }
        }
        return redirect("/login-praktikan");

        // // 0 admin | 1 praktikan
        // if ($request->user()->role == 0) {
        //     return redirect("/login-admin");
        // } else if ($request->user()->role == 1) {
        // }
    }
}
