<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\SiswaPerKelas;
use App\Models\TahunAjar;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportExcel implements ToCollection, WithHeadingRow
{
    public $idKelas;

    public function collection(Collection $rows)
    {
        $tahunAjar = TahunAjar::where('aktif',true)->first();
        foreach ($rows as $row) {
            
            $excelDate = Date::excelToDateTimeObject($row['tanggallahir']);
            $tanggalLahir = $excelDate->format('Y-m-d');

            if($row['namasiswa'] != null){
                $siswa = Siswa::create([
                    'namaSiswa' => $row['namasiswa'],
                    'nik' => $row['nik'],
                    'jenisKelamin' => $row['jeniskelamin'],
                    'tanggalLahir' => $tanggalLahir,
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