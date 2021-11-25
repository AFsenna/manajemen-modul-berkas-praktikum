<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('clear-all', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return '<h1>Cache Clear</h1>';
});

Route::get('/', function () {
    return redirect()->route('auth.login');
});

//group auth
Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/login', [AuthController::class, 'store'])->name('auth.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
//end group auth

Route::middleware(['role:praktikan'])->name('praktikan.')->group(function () {
    Route::get('/dashboard-praktikan', function () {
        return view('praktikan.index');
    })->name('dashboard');

    Route::get('/berkas-praktikum', function () {
        return view('berkasPraktikum.index');
    })->name('berkasPrak');
});

Route::middleware(['role:aslab'])->name('aslab.')->group(function () {
    Route::get('/dashboard-aslab', function () {
        return view('aslab.index');
    })->name('dashboard');

    Route::get('/penyimpanan-modul', function () {
        return view('modulPraktikum.penyimpananModul');
    })->name('penyimpananModul');

    Route::get('/verifikasi-modul', function () {
        return view('modulPraktikum.verifikasiModul');
    })->name('verifikasiModul');

    Route::get('/penyimpanan-berkas', function () {
        return view('berkasPraktikum.pilihPraktikum');
    })->name('penyimpananBerkas');

    Route::post('/penyimpanan-berkas', function () {
        return view('berkasPraktikum.penyimpananBerkas');
    })->name('penyimpananBerkasNext');

    Route::get('/verifikasi-berkas', function () {
        return view('berkasPraktikum.verifikasiBerkas');
    })->name('verifikasiBerkas');
});
