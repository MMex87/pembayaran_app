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

        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->string('faktur');
            $table->string('verifyEmail')->nullable();
            // relasi ke table taginah
            $table->unsignedBigInteger('idTagihan');
            $table->foreign('idTagihan')->references('idTagihan')->on('tagihan');

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
        Schema::drop('transaksi');
    }
};