<?php

namespace App\Http\Controllers\admin\modul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PenyimpananModul;

class PenyimpananModulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->credential;
        $modul = PenyimpananModul::where('credential', $id)->orderBy('idPraktikum', 'ASC')->get();
        $key = date("Ymd");
        $arr = [];
        foreach ($modul as $row) {
            $arr[] = $row->idPraktikum;
        }
        $client = new Client();
        $response = $client->request('POST', 'https://labinformatika.itats.ac.id/api/getPraktikumByID', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode(
                [
                    'key' => $key,
                    'idPraktikum' => $arr,
                ]
            )
        ]);
        $praktikum = json_decode($response->getBody()->getContents());

        $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getAllPraktikum?id=$id&key=$key");
        $praktikumAll = json_decode($response->getBody()->getContents());
        return view('admin.modulPraktikum.penyimpananModul', compact('modul', 'praktikum', 'praktikumAll'));
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
            'idPraktikum' => 'required|unique:penyimpanan_modul,idPraktikum',
            'file_modul' => 'required',
            'harga_modul' => 'required'
        ]);

        try {
            Log::info('Request simpan data modul = ' . json_encode($request->all()));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            $client = new Client();
            $key = date("Ymd");
            $id = $request->idPraktikum;
            $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikum?id=$id&key=$key");
            $praktikum = json_decode($response->getBody()->getContents());
            $namaPraktikum = $praktikum[0]->nama . ' ' . $praktikum[0]->tahun;

            Storage::disk("google")->putFileAs("", $request->file("file_modul"), "$namaPraktikum");
            $result = Storage::disk("google")->getMetadata($namaPraktikum);
            Storage::disk("google")->setVisibility($result['path'], 'public');

            DB::beginTransaction();
            $pmodul =  PenyimpananModul::create([
                'idPraktikum' => $id,
                'harga' => $request->harga_modul,
                'credential' => auth()->user()->credential,
                'id_file' => $result['path'],
            ]);
            Log::info("Data modul baru = " . json_encode($pmodul));
            DB::commit();

            return redirect('/penyimpanan-modul')->with(['jenis' => 'success', 'pesan' => 'Modul Berhasil Disimpan!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error simpan data modul = " . $exception->getMessage());
            Log::error("Error simpan data modul = " . $exception->getFile());
            Log::error("Error simpan data modul = " . $exception->getTraceAsString());

            return redirect()->route('admin.penyimpanan-modul.index')->with(['jenis' => 'error', 'pesan' => 'Modul Gagal Disimpan!']);
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
        $pmodul = PenyimpananModul::find($id);

        $this->validate($request, [
            'idPraktikum' => "required|unique:penyimpanan_modul,idPraktikum,$pmodul->id_pmodul,id_pmodul",
            'harga_modul' => 'required'
        ]);

        try {
            Log::info('Request update data modul berisi = ' . json_encode($pmodul));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            $client = new Client();
            $key = date("Ymd");
            $id = $request->idPraktikum;
            $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikum?id=$id&key=$key");
            $praktikum = json_decode($response->getBody()->getContents());
            $namaPraktikum = $praktikum[0]->nama . ' ' . $praktikum[0]->tahun;

            if ($request->file("file_modul")) {
                Storage::disk("google")->delete($pmodul->id_file);
                Storage::disk("google")->putFileAs("", $request->file("file_modul"), "$namaPraktikum");
                $result = Storage::disk("google")->getMetadata($namaPraktikum);
            } else {
                $result['path'] = $pmodul->id_file;
            }

            DB::beginTransaction();
            $pmodul->update([
                'idPraktikum' => $id,
                'harga' => $request->harga_modul,
                'id_file' => $result['path'],
            ]);

            Log::info("Data modul setelah diupdate = " . json_encode($pmodul));
            DB::commit();

            return redirect('/penyimpanan-modul')->with(['jenis' => 'success', 'pesan' => 'Modul Berhasil Diupdate!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error update data satuan = " . $exception->getMessage());
            Log::error("Error update data satuan = " . $exception->getFile());
            Log::error("Error update data satuan = " . $exception->getTraceAsString());

            return redirect()->route('admin.penyimpanan-modul.index')->with(['jenis' => 'error', 'pesan' => 'Modul Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pmodul = PenyimpananModul::find($id);

        Log::info('Request data modul yang ingin didelete = ' . json_encode($pmodul));
        Log::info("Data User = " . json_encode(auth()->user()));
        Log::info('Start');

        $pmodul->delete();
        // $deleted = Storage::disk("google")->deleteDirectory($firstDir);
        Storage::disk("google")->delete($pmodul->id_file);
        Log::info('Data modul berhasil di delete');

        return redirect()->route('admin.penyimpanan-modul.index')->with(['jenis' => 'success', 'pesan' => 'Berhasil Delete modul']);
    }
}
