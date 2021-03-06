<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PenyimpananModul extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyimpanan_modul', function (Blueprint $table) {
            $table->bigIncrements('id_pmodul');
            $table->string('credential');
            $table->integer('idPraktikum')->unique();
            $table->bigInteger('harga');
            $table->string('id_file');
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
        //
    }
}
