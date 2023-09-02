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
            $table->string('kelas');
            $table->integer('hargaBayar');
            $table->date('tanggalMulai');
            $table->date('tanggalSelesai');
            $table->string('status');
            $table->softDeletes();
            // relasi ke nama tagihan
            $table->unsignedBigInteger('idNamaTagihan');
            $table->foreign('idNamaTagihan')->references('idNamaTagihan')->on('nama_tagihan');

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