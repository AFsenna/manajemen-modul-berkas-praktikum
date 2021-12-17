<?php

use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\{
    AuthController as AuthControllerAdmin,
    DashboardController as DashboardControllerAdmin,
    modul\PenyimpananModulController as PenyimpananModulControllerAdmin,
};

use App\Http\Controllers\praktikan\{
    AuthController as AuthControllerPraktikan,
    DashboardController as DashboardControllerPraktikan,
};
use Illuminate\Http\Client\Request;

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
    return redirect('/login-praktikan');
});

//group auth admin
Route::resource('/login-admin', AuthControllerAdmin::class);
Route::get('/logout-admin', [AuthControllerAdmin::class, 'logout'])->name('auth.logout');
//end group auth

//group auth praktikan
Route::resource('/login-praktikan', AuthControllerPraktikan::class);
Route::get('/logout-praktikan', [AuthControllerPraktikan::class, 'logout'])->name('auth.logout');
//end group auth

Route::middleware(['role:praktikan'])->name('praktikan.')->group(function () {
    Route::get('/dashboard-praktikan', DashboardControllerPraktikan::class)->name('dashboard');

    Route::get('/berkas-praktikum', function () {
        return view('berkasPraktikum.index');
    })->name('berkasPrak');
});

Route::middleware(['role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard-admin', DashboardControllerAdmin::class)->name('dashboard');

    Route::resource('penyimpanan-modul', PenyimpananModulControllerAdmin::class);

    Route::get('/pembelian-modul', function () {
        return view('admin.modulPraktikum.jadwalPembelian');
    })->name('pembelianModul');

    Route::get('/verifikasi-modul', function () {
        return view('admin.modulPraktikum.verifikasiModul');
    })->name('verifikasiModul');

    //group route penyimpanan berkas
    Route::get('/penyimpanan-berkas', function () {
        return view('berkasPraktikum.pilihPraktikum');
    })->name('penyimpananBerkas');

    Route::post('/penyimpanan-berkas', function () {
        return view('berkasPraktikum.penyimpananBerkas');
    });
    //endgroup

    Route::get('/verifikasi-berkas', function () {
        return view('berkasPraktikum.verifikasiBerkas');
    })->name('verifikasiBerkas');
});
