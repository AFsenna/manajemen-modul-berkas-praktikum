<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = "mahasiswa";
    public $primaryKey = 'id_mahasiswa';

    protected $fillable = [
        'nama_mahasiswa', 'notelp_mahasiswa', 'npm_mahasiswa', 'role_id', 'password', 'email_mahasiswa'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
