<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TagihanPerSiswa;
use App\Models\SiswaPerKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Alert;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('mYdiHs');
        $kelas = Kelas::orderBy('namaKelas','ASC')->get();
        $faktur = 'FKT'.$date;
        $view_data=[
            'kelas' => $kelas,
            'faktur' => $faktur
        ];
        
        return view('transaksi.index',$view_data)->with('judul','Pembayaran');
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
        $faktur = $request->input('faktur');
        $idKelas = $request->input('kelas');
        $namaSiswa = $request->input('siswa');
        $idTagihan = $request->input('namaTagihan');
        
        $siswa = Siswa::where([
                            'idKelas' => $idKelas,
                            'namaSiswa' => $namaSiswa
                        ])->first();
        $idSiswa = $siswa->idSiswa;

        $spk = SiswaPerKelas::where([
                                'idSiswa' => $idSiswa,
                                'idKelas' => $idKelas
                            ])->first();

        $tps = TagihanPerSiswa::where([
                            'idSPK' => $spk->idSPK,
                            'idTagihan' =>$idTagihan
                        ])->update([
                            'status' => 'Lunas'
                        ]);

        Transaksi::create([
            'faktur' => $faktur,
            'verify' => 'Belum Verify',
            'idTPS' => $tps
        ]);
        
        Session::flash('success', 'Pembayaran berhasil');
        return redirect('pembayaran');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}