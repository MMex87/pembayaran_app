<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::where('status','aktif')->paginate(10);
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

        Siswa::create([
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
        $kelas = Kelas::where('idkelas',$siswa->idKelas)->first();
        $view_data=[
            'siswa' => $siswa,
            'namaKelas' => $kelas->namaKelas
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

        Siswa::where('idSiswa',$id)->update([
            'namaSiswa' => $namaSiswa,
            'tanggalLahir' => $tanggalLahir,
            'nik' => $nik,
            'jenisKelamin' => $jenisKelamin,
            'noHP' => $nomerWali,
            'alamat' => $alamat,
            'noKIP' => $nomerKIP,
            'namaWali' => $namaWali,
        ]);

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
        //
    }
}