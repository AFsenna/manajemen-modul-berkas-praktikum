<?php

namespace App\Http\Controllers\admin\berkas;

use App\Http\Controllers\Controller;
use App\Models\BerkasPraktikum;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PenyimpananBerkas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client();
        $key = date("Ymd");
        $id = auth()->user()->credential;
        $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getAllPraktikum?id=$id&key=$key");
        $praktikum = json_decode($response->getBody()->getContents());
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
        $client = new Client();
        $key = date("Ymd");
        $id = $request->idPraktikum;
        $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikum?id=$id&key=$key");
        $praktikumAktif = json_decode($response->getBody()->getContents());
        $berkas = BerkasPraktikum::where('idPraktikum', $id)->get();
        return view('admin.berkasPraktikum.showBerkas', compact('praktikumAktif', 'berkas'));
    }
}
