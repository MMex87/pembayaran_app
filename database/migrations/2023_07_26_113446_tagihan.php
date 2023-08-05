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
        // create table
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('idTagihan');
            $table->string('noTagihan');
            $table->string('status');
            // relasi ke nama tagihan
            $table->unsignedBigInteger('idNamaTagihan');
            $table->foreign('idNamaTagihan')->references('idNamaTagihan')->on('nama_tagihan');

            // relasi ke siswa per kelas
            $table->unsignedBigInteger('idSPK');
            $table->foreign('idSPK')->references('idSPK')->on('siswa_per_kelas');

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
        // drop table
        Schema::drop('tagihan');
    }
};