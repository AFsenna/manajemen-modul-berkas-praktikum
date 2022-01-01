<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyimpananModul extends Model
{
    use HasFactory;
    protected $table = "penyimpanan_modul";
    public $primaryKey = 'id_pmodul';

    protected $fillable = [
        'nama_praktikum', 'harga', 'urlberkas', 'credential',
    ];
}
