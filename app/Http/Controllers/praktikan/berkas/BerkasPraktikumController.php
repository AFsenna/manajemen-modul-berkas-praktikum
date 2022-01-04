<?php

namespace App\Http\Controllers\praktikan\berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\BerkasPraktikum;

class BerkasPraktikumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->credential;
        $berkasPrak = BerkasPraktikum::get()->where('npm', $id);
        return view('praktikan.berkasPraktikum', ['berkasPrak' => $berkasPrak]);
    }

    public function getPraktikumJson()
    {
        $client = new Client();
        $key = date("Ymd");
        $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktif?id=1&key=$key");
        $decodeResponse = json_decode($response->getBody()->getContents());
        return response()->json($decodeResponse);
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
        $this->validate($request, [
            'nama_praktikum' => 'required|unique:berkasPraktikum,nama_praktikum',
            'scan_kwitansi' => 'required',
            'pdf_krs' => 'required',
            'pdf_pendaftaran' => 'required',
        ]);

        try {
            Log::info('Request simpan data berkas = ' . json_encode($request->all()));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            $namaFile = auth()->user()->name . '_' . auth()->user()->npm . '_' . $request->nama_praktikum;

            Storage::disk("google")->putFileAs("", $request->file("scan_kwitansi"), "$namaFile" . '_kwitansi');
            Storage::disk("google")->putFileAs("", $request->file("pdf_pendaftaran"), "$namaFile" . '_pendaftaran');
            Storage::disk("google")->putFileAs("", $request->file("pdf_krs"), "$namaFile" . '_krs');
            $kwitansi = Storage::disk("google")->getMetadata("$namaFile" . '_kwitansi');
            $pendaftaran = Storage::disk("google")->getMetadata("$namaFile" . '_pendaftaran');
            $krs = Storage::disk("google")->getMetadata("$namaFile" . '_krs');
            Storage::disk("google")->setVisibility($kwitansi['path'], 'public');
            Storage::disk("google")->setVisibility($pendaftaran['path'], 'public');
            Storage::disk("google")->setVisibility($krs['path'], 'public');

            DB::beginTransaction();
            $berkasPrak =  BerkasPraktikum::create([
                'name' => auth()->user()->name,
                'npm' => auth()->user()->credential,
                'nama_praktikum' => $request->nama_praktikum,
                'idKwitansi' => $kwitansi['path'],
                'idPendaftaran' => $pendaftaran['path'],
                'idKRS' => $krs['path'],
                'status' => 0,
            ]);
            Log::info("Data berkas baru = " . json_encode($berkasPrak));
            DB::commit();

            return redirect('/berkas-praktikum')->with(['jenis' => 'success', 'pesan' => 'Berkas Berhasil Disimpan!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error simpan data berkas = " . $exception->getMessage());
            Log::error("Error simpan data berkas = " . $exception->getFile());
            Log::error("Error simpan data berkas = " . $exception->getTraceAsString());

            return redirect()->route('praktikan.berkas-praktikum.index')->with(['jenis' => 'error', 'pesan' => 'Berkas Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
