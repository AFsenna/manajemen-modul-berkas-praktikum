<?php

/*
    Note : 
    1. untuk menggunakan log : Get-Content storage/logs/laravel.log -wait
    2. pertama kali clone pindahin isi .env.example kedalam .env
    3. PenyimpananModulController sama BerkasPraktikumController emang keliatan error kalo pake extensions intelephense 
        tapi sebenernya udah jalan
    4. login harus pakai akun yang ada di labinfor
*/

use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\{
    AuthController as AuthControllerAdmin,
    DashboardController as DashboardControllerAdmin,
    berkas\PenyimpananBerkasController as PenyimpananBerkasControllerAdmin,
    berkas\VerifikasiBerkasController as VerifikasiBerkasControllerAdmin,
    modul\PenyimpananModulController as PenyimpananModulControllerAdmin,
    modul\JadwalModulController as JadwalModulControllerAdmin,
    modul\VerifikasiModulController as VerifikasiModulControllerAdmin,
};

use App\Http\Controllers\praktikan\{
    AuthController as AuthControllerPraktikan,
    DashboardController as DashboardControllerPraktikan,
    berkas\BerkasPraktikumController as BerkasPraktikumPraktikan,
    modul\ModulPraktikumController as ModulPraktikumPraktikan,
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
    Route::get('/modul', ModulPraktikumPraktikan::class)->name('modul');
});

Route::middleware(['role:0'])->name('admin.')->group(function () {
    Route::get('/dashboard-admin', DashboardControllerAdmin::class)->name('dashboard');

    Route::resource('penyimpanan-modul', PenyimpananModulControllerAdmin::class);

    Route::resource('/jadwal-modul', JadwalModulControllerAdmin::class);

    Route::group(['prefix' => 'verifikasi-modul', 'as' => 'verifikasiModul.'], function () {
        Route::get('/', [VerifikasiModulControllerAdmin::class, 'index'])->name('view');
        Route::get('/exportExcel', [VerifikasiModulControllerAdmin::class, 'exportExcel'])->name('export');
        Route::post('/verifikasi/{id}', [VerifikasiModulControllerAdmin::class, 'verifikasi'])->name('verifikasi');
        Route::post('/batalkan/{id}', [VerifikasiModulControllerAdmin::class, 'batalkan'])->name('batalkan');
    });

    Route::group(['prefix' => 'penyimpanan-berkas', 'as' => 'penyimpananBerkas.'], function () {
        Route::get('/', [PenyimpananBerkasControllerAdmin::class, 'index'])->name('index');
        Route::post('/', [PenyimpananBerkasControllerAdmin::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'verifikasi-berkas', 'as' => 'verifikasiBerkas.'], function () {
        Route::get('/', [VerifikasiBerkasControllerAdmin::class, 'index'])->name('view');
        Route::get('/exportExcel', [VerifikasiBerkasControllerAdmin::class, 'exportExcel'])->name('export');
        Route::post('/verifikasi/{id}', [VerifikasiBerkasControllerAdmin::class, 'verifikasi'])->name('verifikasi');
        Route::post('/tolak/{id}', [VerifikasiBerkasControllerAdmin::class, 'tolak'])->name('tolak');
        Route::post('/batalkan/{id}', [VerifikasiBerkasControllerAdmin::class, 'batalkan'])->name('batalkan');
    });
});
