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

        Schema::create('nama_tagihan', function (Blueprint $table) {
            $table->id('idNamaTagihan');
            $table->date('tanggalMulai');
            $table->date('tanggalSelesai');
            $table->string('namaTagihan');
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
        Schema::drop('nama_tagihan');
    }
};