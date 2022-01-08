<?php

namespace App\Http\Controllers\admin\modul;

use App\Http\Controllers\Controller;
use App\Models\BerkasPraktikum;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerifikasiModulController extends Controller
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
        $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktif?id=$id&key=$key");
        $praktikumAktif = json_decode($response->getBody()->getContents());
        $berkas = BerkasPraktikum::where('idPraktikum', $praktikumAktif[0]->id)->where('status', 1)->get();
        return view('admin.modulPraktikum.verifikasiModul', compact('berkas'));
    }

    public function verifikasi($id)
    {
        $berkasPrak =  BerkasPraktikum::find($id);
        try {
            Log::info('Request verifikasi pembelian modul = ' . json_encode($berkasPrak));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');
            DB::beginTransaction();
            $berkasPrak->update([
                'statusModul' => 1,
            ]);
            Log::info("SUCCESS");
            DB::commit();

            return redirect()->route('admin.verifikasiModul.view')->with(['jenis' => 'success', 'pesan' => 'Pembelian Modul berhasil diverifikasi!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error verifikasi pembelian modul = " . $exception->getMessage());
            Log::error("Error verifikasi pembelian modul = " . $exception->getFile());
            Log::error("Error verifikasi pembelian modul = " . $exception->getTraceAsString());

            return redirect()->route('admin.verifikasiModul.view')->with(['jenis' => 'error', 'pesan' => 'Pembelian Modul Gagal Diverifikasi!']);
        }
    }

    public function batalkan($id)
    {
        $berkasPrak =  BerkasPraktikum::find($id);
        try {
            Log::info('Request pembatalan pembelian modul = ' . json_encode($berkasPrak));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');
            DB::beginTransaction();
            $berkasPrak->update([
                'statusModul' => 0,
            ]);
            Log::info("SUCCESS");
            DB::commit();

            return redirect()->route('admin.verifikasiModul.view')->with(['jenis' => 'success', 'pesan' => 'Pembelian Modul Berhasil Dibatalkan!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error pembatalan pembelian modul = " . $exception->getMessage());
            Log::error("Error pembatalan pembelian modul = " . $exception->getFile());
            Log::error("Error pembatalan pembelian modul = " . $exception->getTraceAsString());

            return redirect()->route('admin.verifikasiModul.view')->with(['jenis' => 'error', 'pesan' => 'Pembelian Modul Gagal Dibatalkan!']);
        }
    }
}
