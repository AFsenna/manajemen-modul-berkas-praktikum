<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPraktikum extends Model
{
    use HasFactory;
    protected $table = "berkasPraktikum";
    public $primaryKey = 'id_berkasPrak';

    protected $fillable = [
        'idPraktikum', 'idKwitansi', 'idPendaftaran', 'idKRS', 'status', 'idUser',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
