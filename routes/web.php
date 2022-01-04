<?php

use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\{
    AuthController as AuthControllerAdmin,
    DashboardController as DashboardControllerAdmin,
    berkas\PenyimpananBerkas as PenyimpananBerkasControllerAdmin,
    modul\PenyimpananModulController as PenyimpananModulControllerAdmin,
};

use App\Http\Controllers\praktikan\{
    AuthController as AuthControllerPraktikan,
    DashboardController as DashboardControllerPraktikan,
    berkas\BerkasPraktikumController as BerkasPraktikumPraktikan,
};
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

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

Route::get('/logout', function () {
    return Auth::logout();
});


//group auth admin
Route::resource('/login-admin', AuthControllerAdmin::class);
Route::get('/logout-admin', [AuthControllerAdmin::class, 'logout'])->name('auth.logout');
//end group auth admin

//group auth praktikan
Route::resource('/login-praktikan', AuthControllerPraktikan::class);
Route::get('/logout-praktikan', [AuthControllerPraktikan::class, 'logout'])->name('auth.logout');
//end group auth praktikan

Route::middleware(['role:1'])->name('praktikan.')->group(function () {
    Route::get('/dashboard-praktikan', DashboardControllerPraktikan::class)->name('dashboard');
    Route::resource('/berkas-praktikum', BerkasPraktikumPraktikan::class);
    Route::get('/berkasPraktikum', [BerkasPraktikumPraktikan::class, 'getPraktikumJson'])->name('berkasPraktikum.getPraktikumJson');
});

Route::middleware(['role:0'])->name('admin.')->group(function () {
    Route::get('/dashboard-admin', DashboardControllerAdmin::class)->name('dashboard');

    //group route penyimpanan modul
    Route::resource('penyimpanan-modul', PenyimpananModulControllerAdmin::class);
    Route::get('/penyimpananModul/getpraktikum', [PenyimpananModulControllerAdmin::class, 'getPraktikumJson'])->name('penyimpananModul.getPraktikumJson');
    //end group route penyimpanan modul

    Route::get('/pembelian-modul', function () {
        return view('admin.modulPraktikum.jadwalPembelian');
    })->name('pembelianModul');

    Route::get('/verifikasi-modul', function () {
        return view('admin.modulPraktikum.verifikasiModul');
    })->name('verifikasiModul');

    Route::resource('/penyimpananBerkas', PenyimpananBerkasControllerAdmin::class);

    Route::get('/verifikasi-berkas', function () {
        return view('berkasPraktikum.verifikasiBerkas');
    })->name('verifikasiBerkas');
});
