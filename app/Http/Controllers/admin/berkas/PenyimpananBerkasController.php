<?php

namespace App\Http\Controllers\admin\berkas;

use App\Http\Controllers\Controller;
use App\Models\BerkasPraktikum;
use Illuminate\Http\Request;
use app\Helpers\ApiLabinfor;

class PenyimpananBerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $praktikum = ApiLabinfor::getAllPraktikum();
        return view('admin.berkasPraktikum.pilihPraktikum', compact('praktikum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->idPraktikum;
        $praktikumAktif = ApiLabinfor::getPraktikum($request->idPraktikum);
        $berkas = BerkasPraktikum::where('idPraktikum', $id)->get();
        return view('admin.berkasPraktikum.showBerkas', compact('praktikumAktif', 'berkas'));
    }
}
