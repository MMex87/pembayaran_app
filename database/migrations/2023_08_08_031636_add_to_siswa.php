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
        Schema::table('siswa', function (Blueprint $table) {
            // Buat kolom baru dengan nama baru
            $table->string('nik')->after('nisn');
            $table->string('jenisKelamin')->after('nis');
            $table->string('noHP')->after('email');
            
            // Tambahkan kolom lain sesuai kebutuhan
            $table->string('noKIP')->nullable()->after('alamat');
            $table->string('namaWali')->after('alamat');
            $table->string('status')->after('alamat');
            $table->date('tanggalLahir')->after('namaSiswa');
        });

        // Pindahkan data dari kolom lama ke kolom baru
        DB::table('siswa')->update([
            'nik' => DB::raw('nisn'),
            'jenisKelamin' => DB::raw('nis'),
            'noHP' => DB::raw('email')
        ]);

        // Hapus kolom lama
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('nisn');
            $table->dropColumn('nis');
            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->renameColumn('nik','nis');
            $table->renameColumn('jenisKelamin','nisn');
            $table->renameColumn('noHP','email');
            $table->dropColumn('noKIP');
            $table->dropColumn('namaWali');
            $table->dropColumn('status');
            $table->dropColumn('tanggalLahir');
        });
    }
};