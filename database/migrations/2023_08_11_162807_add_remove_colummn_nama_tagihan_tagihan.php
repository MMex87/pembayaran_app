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
        // Schema::table('nama_tagihan', function (Blueprint $table){
        //     $table->dropColumn(['tanggalMulai','tanggalSelesai']);
        // });
        Schema::table('tagihan', function (Blueprint $table) {
            $table->date('tanggalMulai')->after('idNamaTagihan');
            $table->date('tanggalSelesai')->after('idNamaTagihan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('tagihan', function (Blueprint $table){
        //     $table->dropColumn(['tanggalMulai','tanggalSelesai']);
        // });
        // Schema::table('nama_tagihan', function (Blueprint $table) {
        //     $table->date('tanggalMulai')->after('namaTagihan');
        //     $table->date('tanggalSelesai')->after('namaTagihan');
        // });
    }
};