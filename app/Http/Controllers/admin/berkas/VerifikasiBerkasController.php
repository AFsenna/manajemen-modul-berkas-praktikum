<?php

namespace App\Http\Controllers\admin\berkas;

use App\Http\Controllers\Controller;
use App\Mail\EmailGoogle;
use App\Models\BerkasPraktikum;
use App\Models\JadwalModul;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Exports\BerkasPraktikumExport;
use app\Helpers\ApiLabinfor;
use App\Models\User;

class VerifikasiBerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $praktikumAktif = ApiLabinfor::getPraktikumAktif();
        $berkas = BerkasPraktikum::where('idPraktikum', $praktikumAktif[0]->id)->get();
        return view('admin.berkasPraktikum.verifikasiBerkas', compact('berkas', 'praktikumAktif'));
    }


    public function exportExcel()
    {
        $key = date("Ymd");
        $praktikumAktif = ApiLabinfor::getPraktikumAktif();
        return \Excel::download(new BerkasPraktikumExport, 'berkas praktikum ' . $praktikumAktif[0]->nama . $praktikumAktif[0]->tahun . ' ' . $key . '.' . 'xlsx');
    }

    public function verifikasi($id)
    {
        $berkasPrak =  BerkasPraktikum::find($id);
        try {
            Log::info('Request verifikasi data berkas berisi = ' . json_encode($berkasPrak));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            $praktikumAktif = ApiLabinfor::getPraktikumAktif();

            $jadwal = JadwalModul::where('idPraktikum', $praktikumAktif[0]->id)->first();

            if ($jadwal == null) {
                return redirect()->route('admin.verifikasiBerkas.view')->with(['jenis' => 'error', 'pesan' => 'Silahkan Atur Jadwal Pembelian Modul Dahulu']);
            }

            $aslab = ApiLabinfor::getAslabByID($jadwal->idAslab);
            $userEmail = User::select('email')->where('id', $berkasPrak->idUser)->first();

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

            Mail::to($userEmail)->send(new EmailGoogle($details));

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

            $praktikumAktif = ApiLabinfor::getPraktikumAktif();

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

            $userEmail = User::select('email')->where('id', $berkasPrak->idUser)->first;
            Mail::to($userEmail)->send(new EmailGoogle($details));

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

    public function batalkan($id)
    {
        $berkasPrak =  BerkasPraktikum::find($id);
        try {
            Log::info('Request tolak data berkas berisi = ' . json_encode($berkasPrak));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            DB::beginTransaction();

            $berkasPrak->update([
                'status' => 0,
            ]);

            $id = auth()->user()->credential;
            $praktikumAktif = ApiLabinfor::getPraktikumAktif($id);

            $details = [
                'title' => 'Berkas Pendaftaran Praktikum Ditolak',
                'body' => 'Status berkas pendaftaran praktikum anda berubah menjadi menunggu verifikasi oleh ' . auth()->user()->name,
                'subject' => 'Informasi Praktikum ' . $praktikumAktif[0]->nama . ' ' . $praktikumAktif[0]->tahun,
                'status' => $berkasPrak->status,
            ];

            $userEmail = User::select('email')->where('id', $berkasPrak->idUser)->first;
            Mail::to($userEmail)->send(new EmailGoogle($details));

            Log::info("SUCCESS");
            DB::commit();

            return redirect()->route('admin.verifikasiBerkas.view')->with(['jenis' => 'success', 'pesan' => 'Berkas tidak jadi ditolak!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error tolak data berkas = " . $exception->getMessage());
            Log::error("Error tolak data berkas = " . $exception->getFile());
            Log::error("Error tolak data berkas = " . $exception->getTraceAsString());

            return redirect()->route('admin.verifikasiBerkas.view')->with(['jenis' => 'error', 'pesan' => 'Berkas Gagal Batal Ditolak!']);
        }
    }
}
