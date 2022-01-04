<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasPraktikumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkasPraktikum', function (Blueprint $table) {
            $table->bigIncrements('id_berkasPrak');
            $table->string('nama_praktikum')->unique();
            $table->string('name', 50);
            $table->string('npm', 16);
            $table->string('idKwitansi');
            $table->string('idPendaftaran');
            $table->string('idKRS');
            $table->integer('status')->comment('0 belum disetujui | 1 disetujui | 2 ditolak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berkas_praktikum');
    }
}
