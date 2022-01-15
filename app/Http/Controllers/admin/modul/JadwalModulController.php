<?php

namespace App\Http\Controllers\admin\modul;

use App\Http\Controllers\Controller;
use App\Models\JadwalModul;
use Illuminate\Http\Request;
use app\Helpers\ApiLabinfor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JadwalModulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $praktikumAktif = ApiLabinfor::getPraktikumAktif();
        $aslabAktif = ApiLabinfor::getAslabAktif();

        $jadwal = JadwalModul::where('idPraktikum', $praktikumAktif[0]->id)->first();

        if ($jadwal) {
            $aslab = ApiLabinfor::getAslabByID($jadwal->idAslab);
        } else {
            $aslab = null;
        }


        return view('admin.modulPraktikum.jadwalPembelian', compact('praktikumAktif', 'aslabAktif', 'jadwal', 'aslab'));
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
            'koordinator' => 'required',
            'lokasi' => 'required',
            'waktu' => 'required'
        ]);

        try {
            Log::info('Request simpan data jadwal = ' . json_encode($request->all()));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            DB::beginTransaction();
            $jadwal =  JadwalModul::create([
                'idAslab' => $request->koordinator,
                'idPraktikum' => $request->idPraktikum,
                'waktuPembelian' => $request->waktu,
                'lokasiPembelian' => $request->lokasi,
            ]);

            Log::info("Data jadwal baru = " . json_encode($jadwal));
            DB::commit();

            return redirect()->route('admin.jadwal-modul.index')->with(['jenis' => 'success', 'pesan' => 'Jadwal Berhasil Disimpan!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error simpan data jadwal = " . $exception->getMessage());
            Log::error("Error simpan data jadwal = " . $exception->getFile());
            Log::error("Error simpan data jadwal = " . $exception->getTraceAsString());

            return redirect()->route('admin.jadwal-modul.index')->with(['jenis' => 'error', 'pesan' => 'Jadwal Gagal Disimpan!']);
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
        $jadwal = JadwalModul::find($id);
        $this->validate($request, [
            'koordinator' => 'required',
            'lokasi' => 'required',
        ]);

        try {
            Log::info('Request update data jadwal berisi = ' . json_encode($jadwal));
            Log::info("Data User = " . json_encode(auth()->user()));
            Log::info('Start');

            if ($request->waktu == null) {
                $request->waktu = $jadwal['waktuPembelian'];
            }

            DB::beginTransaction();
            $jadwal->update([
                'idAslab' => $request->koordinator,
                'idPraktikum' => $request->idPraktikum,
                'waktuPembelian' => $request->waktu,
                'lokasiPembelian' => $request->lokasi,
            ]);

            Log::info("Data jadwal setelah diupdate = " . json_encode($jadwal));
            DB::commit();

            return redirect()->route('admin.jadwal-modul.index')->with(['jenis' => 'success', 'pesan' => 'Jadwal Berhasil Diupdate!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error simpan data jadwal = " . $exception->getMessage());
            Log::error("Error simpan data jadwal = " . $exception->getFile());
            Log::error("Error simpan data jadwal = " . $exception->getTraceAsString());

            return redirect()->route('admin.jadwal-modul.index')->with(['jenis' => 'error', 'pesan' => 'Jadwal Gagal Diupdate!']);
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
        //
    }
}
