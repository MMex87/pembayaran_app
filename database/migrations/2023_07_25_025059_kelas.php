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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('idKelas');
            $table->string('emailWaliKelas');
            $table->string('waliKelas');
            $table->string('namaKelas');
            $table->softDeletes();

            //relasi table tahun ajar
            $table->unsignedBigInteger('idTahunAjar');
            $table->foreign('idTahunAjar')->references('idTahunAjar')->on('tahun_ajar');
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
        Schema::drop('kelas');
    }
};