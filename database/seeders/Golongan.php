<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Golongan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 3 ; $i++) { 
            DB::table('golongan')->insert([
                'namaGolongan' => $i
            ]);
        }
    }
}