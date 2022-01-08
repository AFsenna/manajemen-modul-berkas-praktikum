<?php

namespace App\Http\Controllers\admin\berkas;

use App\Http\Controllers\Controller;
use App\Mail\EmailGoogle;
use App\Models\BerkasPraktikum;
use App\Models\JadwalModul;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class VerifikasiBerkas extends Controller
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
        $berkas = BerkasPraktikum::where('idPraktikum', $praktikumAktif[0]->id)->get();
        return view('admin.berkasPraktikum.verifikasiBerkas', compact('berkas'));
    }


    public function verifikasi($id)
    {
        $berkasPrak =  BerkasPraktikum::find($id);
        try {
            Log::info('Request verifikasi data berkas berisi = ' . json_encode($berkasPrak));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');
            $client = new Client();

            $key = date("Ymd");
            $id = auth()->user()->credential;
            $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktif?id=$id&key=$key");
            $praktikumAktif = json_decode($response->getBody()->getContents());

            $jadwal = JadwalModul::where('idPraktikum', $praktikumAktif[0]->id)->first();

            $response = $client->request('GET', 'https://labinformatika.itats.ac.id/api/getAslabByID?id=' . $jadwal->idAslab . '&key=' . $key);
            $aslab = json_decode($response->getBody()->getContents());


            DB::beginTransaction();
            $berkasPrak->update([
                'status' => 1,
            ]);

            $details = [
                'title' => "Jadwal Pembelian Modul",
                'body' => [
                    'nama' => $aslab[0]->nama,
                    'no_tlpn' => $aslab[0]->no_tlpn,
                    'lokasiPembelian' => $jadwal->lokasiPembelian,
                    'waktuPembelian' => $jadwal->waktuPembelian,
                ],
                'subject' => 'Informasi Praktikum ' . $praktikumAktif[0]->nama . ' ' . $praktikumAktif[0]->tahun,
                'status' => $berkasPrak->status,
            ];

            Mail::to("fgelicia@gmail.com")->send(new EmailGoogle($details));

            Log::info("SUCCESS");
            DB::commit();

            return redirect()->route('admin.verifikasiBerkas.view')->with(['jenis' => 'success', 'pesan' => 'Berkas berhasil diverifikasi!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error verifikasi data berkas = " . $exception->getMessage());
            Log::error("Error verifikasi data berkas = " . $exception->getFile());
            Log::error("Error verifikasi data berkas = " . $exception->getTraceAsString());

            return redirect()->route('admin.verifikasiBerkas.view')->with(['jenis' => 'error', 'pesan' => 'Berkas Gagal Diverifikasi!']);
        }
    }


    public function tolak($id, Request $request)
    {
        $berkasPrak =  BerkasPraktikum::find($id);
        try {
            Log::info('Request tolak data berkas berisi = ' . json_encode($berkasPrak));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');
            $client = new Client();

            $key = date("Ymd");
            $id = auth()->user()->credential;
            $response = $client->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktif?id=$id&key=$key");
            $praktikumAktif = json_decode($response->getBody()->getContents());
            DB::beginTransaction();
            $berkasPrak->update([
                'status' => 2,
            ]);
            $details = [
                'title' => 'Berkas Pendaftaran Praktikum Ditolak',
                'body' => 'Berkas anda ditolak oleh ' . auth()->user()->name . ' karena ' . $request->alasan,
                'subject' => 'Informasi Praktikum ' . $praktikumAktif[0]->nama . ' ' . $praktikumAktif[0]->tahun,
                'status' => $berkasPrak->status,
            ];

            Mail::to("fgelicia@gmail.com")->send(new EmailGoogle($details));
            Log::info("SUCCESS");
            DB::commit();

            return redirect()->route('admin.verifikasiBerkas.view')->with(['jenis' => 'success', 'pesan' => 'Berkas berhasil ditolak!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error tolak data berkas = " . $exception->getMessage());
            Log::error("Error tolak data berkas = " . $exception->getFile());
            Log::error("Error tolak data berkas = " . $exception->getTraceAsString());

            return redirect()->route('admin.verifikasiBerkas.view')->with(['jenis' => 'error', 'pesan' => 'Berkas Gagal Ditolak!']);
        }
    }
}
