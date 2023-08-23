<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // buat kolom baru
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('verify')->after('faktur');
        });

        // pindahkan data dari kolom lama ke kolom baru
        DB::table('transaksi')->update([
            'verifyEmail' => DB::raw('verify')
        ]);

        // hapus kolom lama
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('verifyEmail');
        });

        // Tambah Table Tagihan
        Schema::table('tagihan', function (Blueprint $table) {
            $table->integer('hargaBayar')->after('tanggalMulai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            //
        });
    }
};