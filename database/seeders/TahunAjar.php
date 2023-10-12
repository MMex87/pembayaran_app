<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjar extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tahunSekarang = date('Y');
        $tahun = null; // Inisialisasi variabel $tahun

        if(6 < date('m')){
            $tahun = $tahunSekarang . '/'. ($tahunSekarang + 1);
        } else {
            $tahun = ($tahunSekarang - 1) . '/' . $tahunSekarang;
        }

        DB::table('tahun_ajar')->insert([
            'tahun' => $tahun,
        ]);
    }
}