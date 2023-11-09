<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->string('invoice');
            $table->string('verify')->nullable();
            $table->softDeletes();

            // relasi ke table tagihan
            $table->unsignedBigInteger('idTPS');
            $table->foreign('idTPS')->references('idTPS')->on('tagihan_per_siswa');

            //relasi table users
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('idUser')->on('users');

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
        Schema::drop('transaksi');
    }
};