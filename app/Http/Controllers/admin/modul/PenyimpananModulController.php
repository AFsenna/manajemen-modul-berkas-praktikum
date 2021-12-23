<?php

namespace App\Http\Controllers\admin\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class PenyimpananModulController extends Controller
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
        $decodeResponse = json_decode($response->getBody()->getContents());
        // dd($decodeResponse);

        return view('admin.modulPraktikum.penyimpananModul', ['praktikum' => $decodeResponse]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $username = auth()->user()->name;
        Storage::disk("google")->putFileAs("", $request->file("berkas"), "$username");
        return redirect('/penyimpanan-modul')->with(['jenis' => 'success', 'pesan' => 'Modul Berhasil Disimpan!']);
        // dd($request->file("berkas")->store("", "google"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $files = Storage::disk("google")->allFiles();
        $firstFileName = $files[0];
        dump("File Name : " . $firstFileName);
        $details = Storage::disk('google')->getMetaData($firstFileName);
        dump($details);
        $url = Storage::disk('google')->url($firstFileName);
        dump("Download URL :" . $url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
