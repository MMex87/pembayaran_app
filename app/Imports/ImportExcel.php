<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\SiswaPerKelas;
use App\Models\TahunAjar;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ImportExcel implements ToCollection, WithHeadingRow
{
    public $idKelas;

    public function collection(Collection $rows)
    {
        $tahunAjar = TahunAjar::orderByDESC('idTahunAjar')->first();
        foreach ($rows as $row) {
            if($row['namasiswa'] != null){
                $siswa = Siswa::create([
                    'namaSiswa' => $row['namasiswa'],
                    'nik' => $row['nik'],
                    'jenisKelamin' => $row['jeniskelamin'],
                    'noHP' => $row['nohp'],
                    'alamat' => $row['alamat'],
                    'noKIP' => $row['nokip'] == null ? '' : $row['nokip'],
                    'namaWali' => $row['namawali'],
                    'status' => $row['status'],
                    'idKelas' => $this->idKelas,
                ]);
                SiswaPerKelas::create([
                    'idKelas' => $this->idKelas,
                    'idSiswa' => $siswa->idSiswa,
                    'idTahunAjar' => $tahunAjar->idTahunAjar
                ]);
            }
        }
    }
}