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
            $table->integer('idPraktikum');
            $table->integer('idUser');
            $table->string('idKwitansi');
            $table->string('idPendaftaran');
            $table->string('idKRS');
            $table->integer('status')->comment('0 belum disetujui | 1 disetujui | 2 ditolak');
            $table->integer('statusModul')->comment('0 belum dibeli | 1 lunas');
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
