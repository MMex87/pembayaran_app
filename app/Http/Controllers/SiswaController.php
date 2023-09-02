<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\SiswaPerKelas;
use App\Models\TahunAjar;
use Spatie\SimpleExcel\SimpleExcelReader;
use PHPExcel_IOFactory;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = SiswaPerKelas::with(['siswa', 'kelas'])
                                ->join('siswa', 'siswa_per_kelas.idSiswa', '=', 'siswa.idSiswa')
                                ->where('siswa.status', 'aktif')
                                ->orderByDesc('siswa.idSiswa')
                                ->paginate(10);
        $view_data=[
            'siswa' => $siswa
        ];
        $judul = 'Siswa';
        return view('siswa.index',$view_data)->with('judul', $judul);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::get();
        $view_data=[
            'kelas' => $kelas
        ];
        $judul = 'Siswa';
        return view('siswa.create',$view_data)->with('judul',$judul);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $namaSiswa=$request->input('namaSiswa');
        $nik = $request->input('nik');
        $tanggalLahir = $request->input('tanggalLahir');
        $jenisKelamin = $request->input('jenisKelamin');
        $idKelas = $request->input('kelas');
        $namaWali = $request->input('waliSiswa');
        $alamat = $request->input('alamat');
        $nomerWali = $request->input('noWali');
        $nomerKIP = $request->input('noKIP');
        
        $siswa = Siswa::create([
            'namaSiswa' => $namaSiswa,
            'tanggalLahir' => $tanggalLahir,
            'nik' => $nik,
            'jenisKelamin' => $jenisKelamin,
            'noHP' => $nomerWali,
            'alamat' => $alamat,
            'idKelas' =>$idKelas,
            'noKIP' => $nomerKIP,
            'namaWali' => $namaWali,
            'status' => 'aktif'
        ]);
        
        $tahunAjar = TahunAjar::orderByDESC('idTahunAjar')->first();

        SiswaPerKelas::create([
            'idSiswa' => $siswa->id,
            'idTahunAjar' => $tahunAjar->idTahunAjar,
            'idKelas' => $idKelas
        ]);


        return redirect('siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Siswa::where('idSiswa',$id)->first();
        $kelas = Kelas::where('idKelas',$siswa->idKelas)->first();
        $data_kelas = Kelas::get();

        $view_data=[
            'siswa' => $siswa,
            'namaKelas' => $kelas->namaKelas,
            'kelas' => $data_kelas,
        ];
        return view('siswa.detail',$view_data)->with('judul','Siswa');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $namaSiswa=$request->input('namaSiswa');
        $nik = $request->input('nik');
        $tanggalLahir = $request->input('tanggalLahir');
        $jenisKelamin = $request->input('jenisKelamin');
        $idKelas = $request->input('kelas');
        $namaWali = $request->input('waliSiswa');
        $alamat = $request->input('alamat');
        $nomerWali = $request->input('noWali');
        $nomerKIP = $request->input('noKIP');
        
        $siswa = Siswa::where('idSiswa',$id)->first();
        
        Siswa::where('idSiswa',$id)->update([
            'namaSiswa' => $namaSiswa,
            'tanggalLahir' => $tanggalLahir,
            'nik' => $nik,
            'jenisKelamin' => $jenisKelamin,
            'noHP' => $nomerWali,
            'idKelas' => $idKelas,
            'alamat' => $alamat,
            'noKIP' => $nomerKIP,
            'namaWali' => $namaWali,
        ]);

        if($idKelas != $siswa->idKelas){
            SiswaPerKelas::where('idSiswa',$id)->update([
                'idKelas' => $idKelas
            ]);
        }

        return redirect("/siswa/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Siswa::where('idSiswa',$id)->delete();
        SiswaPerKelas::where('idSiswa',$id)->delete();

        return redirect('siswa');
    }

    public function import(Request $request)
    {
        $file = $request->file('inputExcel');

        $filePath = $file->getPathname();

        // Inisialisasi objek PHPExcel
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        
        dd($objPHPExcel);
        
        // Mendapatkan sheet aktif
        $worksheet = $objPHPExcel->getActiveSheet();

        // Mendapatkan data dalam bentuk array
        $data = $worksheet->toArray();


        $reader = SimpleExcelReader::create($file->getPathname())->getRows();


        foreach ($reader as $row) {
            Item::create([
                'name' => $row['nama'], // Sesuaikan dengan nama kolom di Excel
                'description' => $row['deskripsi'], // Sesuaikan dengan nama kolom di Excel
                // Tambahkan kolom lain sesuai kebutuhan
            ]);
        }

        return redirect()->back()->with('success', 'Data imported successfully!');
    }
}