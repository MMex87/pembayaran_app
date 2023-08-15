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
        // Schema::table('tagihan_per_siswa', function (Blueprint $table) {
            
        //     $table->dropForeign(['idSPK','idTagihan']);
        //     $table->dropColumn('idSPK');
        //     $table->dropColumn('idTagihan');
        // });
        Schema::drop('tagihan_per_siswa');
    }
};