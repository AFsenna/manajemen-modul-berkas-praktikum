<?php

namespace App\Exports;

use App\Models\BerkasPraktikum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use app\Helpers\ApiLabinfor;

class ModulPraktikumExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $praktikumAktif = ApiLabinfor::getPraktikumAktif();
        return BerkasPraktikum::where('idPraktikum', $praktikumAktif[0]->id)->where('status', '>', 0)->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NPM',
            'status',
        ];
    }

    public function map($berkaspraktikum): array
    {
        if ($berkaspraktikum->statusModul == 0) {
            $status = 'Belum Dibeli';
        } else if ($berkaspraktikum->statusModul == 1) {
            $status = 'Lunas';
        }

        return [
            $berkaspraktikum->users->name,
            $berkaspraktikum->users->credential,
            $status,
        ];
    }
}
