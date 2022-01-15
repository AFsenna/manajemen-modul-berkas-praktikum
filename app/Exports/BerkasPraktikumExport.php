<?php

namespace App\Exports;

use App\Models\BerkasPraktikum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use app\Helpers\ApiLabinfor;

class BerkasPraktikumExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $praktikumAktif = ApiLabinfor::getPraktikumAktif();
        return BerkasPraktikum::where('idPraktikum', $praktikumAktif[0]->id)->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NPM',
            'Kwitansi',
            'Berkas Pendaftaran',
            'KRS',
            'status',
        ];
    }

    public function map($berkaspraktikum): array
    {
        if ($berkaspraktikum->status == 0) {
            $status = 'Belum Disetujui';
        } else if ($berkaspraktikum->status == 1) {
            $status = 'Disetujui';
        } else if ($berkaspraktikum->status == 2) {
            $status = 'Berkas Ditolak';
        }

        return [
            $berkaspraktikum->users->name,
            $berkaspraktikum->users->credential,
            'https://drive.google.com/uc?export=view&id=' . $berkaspraktikum->idKwitansi,
            'https://drive.google.com/uc?id=' . $berkaspraktikum->idPendaftaran . '&export=media',
            'https://drive.google.com/uc?id=' . $berkaspraktikum->idKRS . '&export=media',
            $status,
        ];
    }
}
