<?php

namespace App\Http\Controllers\praktikan\berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\BerkasPraktikum;
use Illuminate\Validation\Rule;

class BerkasPraktikumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        $berkasPrak = BerkasPraktikum::where('idUser', $id)->orderBy('idPraktikum', 'ASC')->get();
        $key = date("Ymd");
        $arr = [];
        foreach ($berkasPrak as $row) {
            $arr[] = $row->idPraktikum;
        }
        $client = new Client();
        $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktifAll?key=$key");
        $praktikumAktif = json_decode($response->getBody()->getContents());

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
        return view('praktikan.berkasPraktikum', compact('berkasPrak', 'praktikum', 'praktikumAktif'));
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
        $idPrak = $request->idPraktikum;
        $idUser = auth()->user()->id;
        $this->validate($request, [
            'idPraktikum' => [
                "required",
                Rule::unique('berkasPraktikum')->where(function ($query) use ($idPrak, $idUser) {
                    return $query->where('idPraktikum', $idPrak)->where('idUser', $idUser);
                })
            ],
            'scan_kwitansi' => 'required',
            'pdf_krs' => 'required',
            'pdf_pendaftaran' => 'required',
        ]);

        try {
            Log::info('Request simpan data berkas = ' . json_encode($request->all()));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            $client = new Client();
            $key = date("Ymd");
            $id = $request->idPraktikum;
            $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikum?id=$id&key=$key");
            $praktikum = json_decode($response->getBody()->getContents());
            $namaPraktikum = $praktikum[0]->nama . ' ' . $praktikum[0]->tahun;
            $namaFile = auth()->user()->name . '_' . auth()->user()->npm . '_' . $namaPraktikum;

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
                'idUser' => auth()->user()->id,
                'idPraktikum' => $id,
                'idKwitansi' => $kwitansi['path'],
                'idPendaftaran' => $pendaftaran['path'],
                'idKRS' => $krs['path'],
                'status' => 0,
                'statusModul' => 0,
            ]);
            Log::info("Data berkas baru = " . json_encode($berkasPrak));
            DB::commit();

            return redirect()->route('praktikan.berkas-praktikum.index')->with(['jenis' => 'success', 'pesan' => 'Berkas Berhasil Disimpan!']);
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
        $idPrak = $request->idPraktikum;
        $idUser = auth()->user()->id;
        $berkasPrak =  BerkasPraktikum::find($id);
        $this->validate($request, [
            'idPraktikum' => [
                "required",
                Rule::unique('berkasPraktikum')->where(function ($query) use ($idPrak, $idUser, $berkasPrak) {
                    return $query->where('idPraktikum', $idPrak)->where('idUser', $idUser)->whereNotIn('id_berkasPrak', [$berkasPrak->id_berkasPrak]);
                })
            ],
        ]);

        try {
            Log::info('Request update data berkas berisi = ' . json_encode($berkasPrak));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            $client = new Client();
            $key = date("Ymd");
            $id = $request->idPraktikum;
            $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikum?id=$id&key=$key");
            $praktikum = json_decode($response->getBody()->getContents());
            $namaPraktikum = $praktikum[0]->nama . ' ' . $praktikum[0]->tahun;
            $namaFile = auth()->user()->name . '_' . auth()->user()->npm . '_' . $namaPraktikum;

            if ($request->file("scan_kwitansi")) {
                Storage::disk("google")->delete($berkasPrak->idKwitansi);
                Storage::disk("google")->putFileAs("", $request->file("scan_kwitansi"), "$namaFile" . '_kwitansi');
                $kwitansi = Storage::disk("google")->getMetadata("$namaFile" . '_kwitansi');
                Storage::disk("google")->setVisibility($kwitansi['path'], 'public');
            } else {
                $kwitansi['path'] = $berkasPrak->idKwitansi;
            }

            if ($request->file("pdf_krs")) {
                Storage::disk("google")->delete($berkasPrak->idKRS);
                Storage::disk("google")->putFileAs("", $request->file("idKRS"), "$namaFile" . '_krs');
                $krs = Storage::disk("google")->getMetadata("$namaFile" . '_krs');
                Storage::disk("google")->setVisibility($krs['path'], 'public');
            } else {
                $krs['path'] = $berkasPrak->idKRS;
            }

            if ($request->file("pdf_pendaftaran")) {
                Storage::disk("google")->delete($berkasPrak->idPendaftaran);
                Storage::disk("google")->putFileAs("", $request->file("pdf_pendaftaran"), "$namaFile" . '_pendaftaran');
                $pendaftaran = Storage::disk("google")->getMetadata("$namaFile" . '_pendaftaran');
                Storage::disk("google")->setVisibility($pendaftaran['path'], 'public');
            } else {
                $pendaftaran['path'] = $berkasPrak->idKRS;
            }

            DB::beginTransaction();
            $berkasPrak->update([
                'idPraktikum' => $id,
                'idKwitansi' => $kwitansi['path'],
                'idPendaftaran' => $pendaftaran['path'],
                'idKRS' => $krs['path'],
            ]);

            Log::info("Data modul setelah diupdate = " . json_encode($berkasPrak));
            DB::commit();

            return redirect()->route('praktikan.berkas-praktikum.index')->with(['jenis' => 'success', 'pesan' => 'Berkas Berhasil Diupdate!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error update data berkas = " . $exception->getMessage());
            Log::error("Error update data berkas = " . $exception->getFile());
            Log::error("Error update data berkas = " . $exception->getTraceAsString());

            return redirect()->route('praktikan.berkas-praktikum.index')->with(['jenis' => 'error', 'pesan' => 'Berkas Gagal Diupdate!']);
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
        $berkasPrak =  BerkasPraktikum::find($id);

        Log::info('Request data berkas yang ingin didelete = ' . json_encode($berkasPrak));
        Log::info("Data User = " . json_encode(auth()->user()));
        Log::info('Start');

        $berkasPrak->delete();

        Storage::disk("google")->delete($berkasPrak->idKwitansi);
        Storage::disk("google")->delete($berkasPrak->idPendaftaran);
        Storage::disk("google")->delete($berkasPrak->idKRS);

        Log::info('Data berkas berhasil di delete');

        return redirect()->route('praktikan.berkas-praktikum.index')->with(['jenis' => 'success', 'pesan' => 'Berhasil Delete berkas']);
    }
}
