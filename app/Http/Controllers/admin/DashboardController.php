<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BerkasPraktikum;
use App\Models\PenyimpananModul;
use Illuminate\Http\Request;
use app\Helpers\ApiLabinfor;


class DashboardController extends Controller
{

    public function __invoke()
    {
        $id = auth()->user()->credential;

        $modul = PenyimpananModul::where('credential', $id)->count();

        $praktikumAktif = ApiLabinfor::getPraktikumAktif();

        // $praktikan = BerkasPraktikum::where()
        return view('admin.index', compact('modul', 'praktikumAktif'));
    }
}
