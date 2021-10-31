<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "role";
    public $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'role_id');
    }
}
