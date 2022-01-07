<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalModul extends Model
{
    use HasFactory;
    protected $table = "jadwal_modul";
    public $primaryKey = 'id_jadwal';

    protected $fillable = [
        'idAslab', 'idPraktikum', 'lokasiPembelian', 'waktuPembelian',
    ];
}
