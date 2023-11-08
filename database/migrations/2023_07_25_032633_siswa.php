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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('idSiswa');
            $table->string('namaSiswa');
            $table->string('nik');
            $table->string('jenisKelamin');
            $table->date('tanggalLahir')->default('2000-01-01');
            $table->string('noHP')->nullable();
            $table->string('alamat');
            $table->string('status');
            $table->string('noKIP')->nullable();
            $table->string('namaWali');
            $table->softDeletes();

            // relasi table kelas
            $table->unsignedBigInteger('idKelas');
            $table->foreign('idKelas')->references('idKelas')->on('kelas');
            
            // relasi table golongan
            $table->unsignedBigInteger('idGolongan');
            $table->foreign('idGolongan')->references('idGolongan')->on('golongan');
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
        Schema::drop('siswa');
    }
};