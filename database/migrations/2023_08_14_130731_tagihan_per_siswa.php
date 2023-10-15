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
        Schema::create('tagihan_per_siswa', function (Blueprint $table) {
            $table->bigIncrements('idTPS');
            $table->string('noTagihan');
            $table->string('status');
            $table->softDeletes();

            //relasi table tagihan
            $table->unsignedBigInteger('idTagihan');
            $table->foreign('idTagihan')->references('idTagihan')->on('tagihan');
            
            //relasi table SPK
            $table->unsignedBigInteger('idSPK');
            $table->foreign('idSPK')->references('idSPK')->on('siswa_per_kelas');

            //relasi table tahun ajar
            $table->unsignedBigInteger('idTahunAjar');
            $table->foreign('idTahunAjar')->references('idTahunAjar')->on('tahun_ajar');

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
        Schema::drop('tagihan_per_siswa');
    }
};