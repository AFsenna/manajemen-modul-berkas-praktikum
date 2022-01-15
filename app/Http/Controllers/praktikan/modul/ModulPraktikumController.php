<?php

namespace App\Http\Controllers\praktikan\modul;

use App\Http\Controllers\Controller;
use App\Models\BerkasPraktikum;
use Illuminate\Http\Request;
use app\Helpers\ApiLabinfor;

class ModulPraktikumController extends Controller
{
    public function __invoke()
    {
        $berkas = BerkasPraktikum::where('status', '>', 0)->where('idUser', auth()->user()->id)->get();
        $arr = [];
        foreach ($berkas as $row) {
            $arr[] = $row->idPraktikum;
        }
        $praktikum = ApiLabinfor::getPraktikumByID($arr);
        return view('praktikan.modulPraktikum', compact('berkas', 'praktikum'));
    }
}
