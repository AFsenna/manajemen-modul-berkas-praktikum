<?php

namespace App\Http\Controllers\admin\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PenyimpananModul;
use Stringable;

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

        $pmodul = PenyimpananModul::get()->where('credential', $id);
        return view('admin.modulPraktikum.penyimpananModul', ['praktikum' => $decodeResponse, 'modul' => $pmodul]);
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
            'nama_praktikum' => 'required|unique:penyimpanan_modul,nama_praktikum',
            'file_modul' => 'required',
            'harga_modul' => 'required'
        ]);
        try {
            Log::info('Request simpan data modul = ' . json_encode($request->all()));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');


            DB::beginTransaction();
            $pmodul =  PenyimpananModul::create([
                'nama_praktikum' => $request->nama_praktikum,
                'harga' => $request->harga_modul,
                'urlberkas' => '#',
                'credential' => auth()->user()->credential,
            ]);
            Log::info("Data modul pertama = " . json_encode($pmodul));
            DB::commit();
            Storage::disk("google")->putFileAs("", $request->file("file_modul"), "$request->nama_praktikum");
            $files = Storage::disk("google")->allFiles();
            // dd($pmodul->id_pmodul);
            $id = $pmodul->id_pmodul;
            $firstFileName = $files[$id - 1];
            Storage::disk("google")->setVisibility($firstFileName, 'private');
            $url = Storage::disk('google')->url($firstFileName);

            $update = PenyimpananModul::find($id);

            $pmodul = $update->update([
                'urlberkas' => $url,
            ]);
            DB::commit();
            Log::info("Data modul final = " . json_encode($pmodul));

            return redirect('/penyimpanan-modul')->with(['jenis' => 'success', 'pesan' => 'Modul Berhasil Disimpan!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error simpan data modul = " . $exception->getMessage());
            Log::error("Error simpan data modul = " . $exception->getFile());
            Log::error("Error simpan data modul = " . $exception->getTraceAsString());

            return redirect('/penyimpanan-modul')->with(['jenis' => 'error', 'pesan' => 'Modul Gagal Disimpan!']);
        }
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
        // Storage::disk("google")->makeDirectory("michael");
        $dirs = Storage::disk("google")->directories();
        $files = Storage::disk("google")->allFiles();
        $firstDir = $files[0];
        $deleted = Storage::disk("google")->deleteDirectory($firstDir);
        $deleted = Storage::disk("google")->delete($firstDir);
        dd($dirs);
    }
}
