<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    public $primaryKey = 'id_mahasiswa';
    protected $table = "mahasiswa";

    protected $guarded = [];

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }
}
