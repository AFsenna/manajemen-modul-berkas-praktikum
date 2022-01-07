<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalModulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_modul', function (Blueprint $table) {
            $table->bigIncrements('id_jadwal');
            $table->integer('idAslab');
            $table->integer('idPraktikum')->unique();
            $table->longText('lokasiPembelian');
            $table->dateTime('waktuPembelian');
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
        Schema::dropIfExists('jadwal_modul');
    }
}
