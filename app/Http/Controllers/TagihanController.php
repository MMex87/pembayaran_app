<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\NamaTagihan;
use App\Models\Kelas;
use App\Models\SiswaPerKelas;
use App\Models\TagihanPerSiswa;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagihan = Tagihan::with('namaTagihan')->paginate(5);
        $data_view=[
            'tagihan' => $tagihan  
        ];
        
        return view('tagihan.index',$data_view)->with('judul','Tagihan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $namaTagihan = NamaTagihan::get();
        $kelas = Kelas::get();

        $data_view=[
            'namaTagihan' => $namaTagihan,
            'kelas' => $kelas
        ];

        return view('tagihan.create',$data_view)->with('judul','Tagihan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idTagihan = $request->input('namaTagihan');
        $tanggalMulai = $request->input('tanggalMulai');
        $tanggalSelesai = $request->input('tanggalSelesai');
        $hargaBayar = $request->input('hargaBayar');
        $status = $request->input('status');
        $selectKelas = $request->input('checkKelas',[]);
        $selctAllKelas = $request->input('allCheckKelas');

        $kelas = Kelas::orderBy('namaKelas','ASC')->get();

        $dataKelas;
        

        if($selctAllKelas == 'semua kelas'){
            $temp = array();
            foreach ($kelas as $val ) {
                array_push($temp,$val->namaKelas);
            }
            $dataKelas = implode(',',$temp);
        }else{
            $temp = array();
            foreach ($selectKelas as $item) {
                $kelasLike = Kelas::where('namaKelas','LIKE',$item .'%')->get();
                foreach ($kelasLike as $item2) {
                    array_push($temp,$item2->namaKelas);
                }
            }
            $dataKelas = implode(',',$temp);
        }

        // create Tagihan
        $tagihan = Tagihan::create([
            'idNamaTagihan' => $idTagihan,
            'tanggalMulai' => $tanggalMulai,
            'hargaBayar' => $hargaBayar,
            'tanggalSelesai' => $tanggalSelesai,
            'kelas' => $dataKelas,
            'status' => $status
        ]);

        // generate tagihan per siswa
        if($selctAllKelas == 'semua kelas'){
            foreach ($kelas as $val ) {
                $siswa = SiswaPerKelas::where('idKelas',$val->idKelas)->get();
                
                // dd($siswa->idSPK);
                foreach ($siswa as $item) {
                    // random number for noTagihan
                    $randomNumbers = [];
    
                    for ($i = 0; $i < 10; $i++) {
                        $randomNumbers[] = random_int(0, 9); // Ganti rentang sesuai kebutuhan Anda
                    }
                    $randomNumbers = implode('',$randomNumbers);
                    $noInvoice= $randomNumbers;
                    
                    TagihanPerSiswa::create([
                        'noTagihan' => $noInvoice,
                        'status' => 'Belum Lunas',
                        'idTagihan' => $tagihan->idTagihan,
                        'idSPK' => $item->idSPK
                    ]);
                }
            }
        }else{
            foreach ($selectKelas as $item) {
                $kelasLike = Kelas::where('namaKelas','LIKE',$item .'%')->get();
                foreach ($kelasLike as $val ) {
                    $siswa = SiswaPerKelas::where('idKelas',$val->idKelas)->get();
                
                    // dd($siswa->idSPK);
                    foreach ($siswa as $item) {
                        // random number for noTagihan
                        $randomNumbers = [];
        
                        for ($i = 0; $i < 10; $i++) {
                            $randomNumbers[] = random_int(0, 9); // Ganti rentang sesuai kebutuhan Anda
                        }
                        $randomNumbers = implode('',$randomNumbers);
                        $noInvoice= $randomNumbers;
                        
                        TagihanPerSiswa::create([
                            'noTagihan' => $noInvoice,
                            'status' => 'Belum Lunas',
                            'idTagihan' => $tagihan->idTagihan,
                            'idSPK' => $item->idSPK
                        ]);
                    }
                }
            }
        }

        return redirect('tagihan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tagihan $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tagihan $tagihan)
    {
        //
    }

    public function getTagihan(Request $request)
    {
        $idSiswa = $request->idSiswa;
        $idKelas = $request->idKelas;

        // $idSiswa = Siswa::where(['idSiswa'=> $idSiswa,'idKelas' => $idKelas])->first();
        
        $idSPK = SiswaPerKelas::where([
                                    'idSiswa' => $idSiswa,
                                    'idKelas' => $idKelas
                                    ])->first();

        
        $tagihanPerSiswa = TagihanPerSiswa::where([
                                                'idSPK' => $idSPK->idSPK,
                                                'status' => 'Belum Lunas'
                                                ])->get();
        
        $idTagihans = $tagihanPerSiswa->pluck('idTagihan');
        
        $tagihan = Tagihan::with('namaTagihan')
                            ->whereIn('idTagihan',$idTagihans)
                            ->get();
                            
        return response()->json($tagihan);
    }

    public function getTotalTagihan(Request $request)
    {
        $idTagihan = $request->idTagihan;

        $tagihan = Tagihan::where('idTagihan', $idTagihan)
                            ->first();
        return response()->json($tagihan);
    }
}