<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Kelas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 7; $i++) { 
            DB::table('kelas')->insert([
                'namaKelas' => $i.'A',
                'waliKelas' => 'Wali Kelas '.$i.'A',
                'emailWaliKelas' => 'gurukelas'.$i.'A@gmail.com',
                'idTahunAjar' => 1
            ]);
            DB::table('kelas')->insert([
                'namaKelas' => $i.'B',
                'waliKelas' => 'Wali Kelas '.$i.'B',
                'emailWaliKelas' => 'gurukelas'.$i.'B@gmail.com',
                'idTahunAjar' => 1
            ]);
        }
    }
}