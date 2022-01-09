<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BerkasPraktikum;
use App\Models\PenyimpananModul;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class DashboardController extends Controller
{

    public function __invoke()
    {
        $client = new Client();
        $key = date("Ymd");
        $id = auth()->user()->credential;

        $modul = PenyimpananModul::where('credential', auth()->user()->credential)->count();

        $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktif?id=$id&key=$key");
        $praktikumAktif = count(json_decode($response->getBody()->getContents()));

        // $praktikan = BerkasPraktikum::where()
        return view('admin.index', compact('modul', 'praktikumAktif'));
    }
}
