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
        Schema::table('tagihan', function (Blueprint $table) {
            $table->string('kelas')->after('tanggalMulai');
            $table->dropColumn('noTagihan');
            $table->dropForeign(['idSPK']);
            $table->dropColumn('idSPK');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagihan', function (Blueprint $table) {
            // $table->string('noTagihan');
            // $table->dropColumn('kelas');

            // relasi ke siswa per kelas
            // $table->unsignedBigInteger('idSPK');
            // $table->foreign('idSPK')->references('idSPK')->on('siswa_per_kelas');
        });
    }
};