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
        $invoice;
        $daftarTagihan;
        $tagihan = TagihanPerSiswa::with(['tagihan.namaTagihan', 'transaksi','siswaPerKelas.siswa'])
                                        ->where('status','Cart')
                                        ->get();

        if($tagihan->isNotEmpty()){
            $invoice = $tagihan[0]->transaksi->invoice;
            $idSPK = $tagihan[0]->idSPK;
            $daftarTagihan = TagihanPerSiswa::with('tagihan.namaTagihan')
                                                ->where(['idSPK'=>$idSPK, 'status'=>'Belum Lunas'])->get();
            // dd($daftarTagihan[0]->idTagihan);
            
        }else{
            $invoice = 'INV'.$date;
        }

        // dd($tagihan[0]->siswaPerKelas->siswa->idKelas);

        $view_data=[
            'kelas' => $kelas,
            'invoice' => $invoice,
            'tagihan' => $tagihan,
            'daftarTagihan' => $daftarTagihan
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
        $invoice = $request->input('invoice');
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
                                ])->first();

        TagihanPerSiswa::where([
                            'idTPS' => $tps->idTPS
                        ])->update([
                            'status' => 'Cart'
                        ]);
        
        Transaksi::create([
            'invoice' => $invoice,
            'verify' => 'Belum Verify',
            'idTPS' => $tps->idTPS
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