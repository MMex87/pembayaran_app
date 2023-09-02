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
        Schema::create('siswa_per_kelas', function (Blueprint $table) {
            $table->id('idSPK');
            $table->softDeletes();
            
            // relasi table siswa
            $table->unsignedBigInteger('idSiswa');
            $table->foreign('idSiswa')->references('idSiswa')->on('siswa');
            
            //relasi table tahun ajar
            $table->unsignedBigInteger('idTahunAjar');
            $table->foreign('idTahunAjar')->references('idTahunAjar')->on('tahun_ajar');
            
            // relasi table kelas
            $table->unsignedBigInteger('idKelas');
            $table->foreign('idKelas')->references('idKelas')->on('kelas');


            // $table->timestamps();
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
        Schema::drop('siswa_per_kelas');
    }
};