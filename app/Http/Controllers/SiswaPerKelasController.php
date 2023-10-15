<?php

namespace App\Http\Controllers;

use App\Models\SiswaPerKelas;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaPerKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\siswaPerKelas  $siswaPerKelas
     * @return \Illuminate\Http\Response
     */
    public function show(siswaPerKelas $siswaPerKelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\siswaPerKelas  $siswaPerKelas
     * @return \Illuminate\Http\Response
     */
    public function edit(siswaPerKelas $siswaPerKelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\siswaPerKelas  $siswaPerKelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, siswaPerKelas $siswaPerKelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\siswaPerKelas  $siswaPerKelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(siswaPerKelas $siswaPerKelas)
    {
        //
    }

    public function getSiswa(Request $request)
    {
        $idKelas = $request->idKelas;
        $namaSiswa = $request->namaSiswa;

        // Lakukan pencarian data siswa sesuai dengan $namaSiswa
        $siswaPerKelas = SiswaPerKelas::with('tahunAjar')
                                    ->whereHas('tahunAjar',function($query){
                                        $query->where('aktif',true);
                                    })
                                    ->where('idKelas', $idKelas)->get();

        $siswaIds = $siswaPerKelas->pluck('idSiswa');

        $siswa = Siswa::whereIn('idSiswa', $siswaIds)
            ->where('namaSiswa', 'LIKE', '%' . $namaSiswa . '%')
            ->get();

        return response()->json($siswa);
    }
}