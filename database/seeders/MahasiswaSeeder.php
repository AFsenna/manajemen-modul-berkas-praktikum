<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mahasiswa::create([
            'nama_mahasiswa' => 'Alexandria Felicia Seanne',
            'npm_mahasiswa' => '06.2019.1.07103',
            'role_id' => 1,
            'notelp_mahasiswa' => '082285132960',
            'email_mahasiswa' => 'fgelicia@gmail.com',
            'password' => Hash::make('senna'),
        ]);
        Mahasiswa::create([
            'nama_mahasiswa' => 'Michael Araona Wily',
            'npm_mahasiswa' => '06.2018.1.07128',
            'role_id' => 2,
            'notelp_mahasiswa' => '082285132960',
            'email_mahasiswa' => 'araona@gmail.com',
            'password' => Hash::make('araona'),
        ]);
        User::create([
            'name' => 'senna',
            'email' => 'gaja@gmail.com',
            'password' => Hash::make('senna')
        ]);
    }
}
