<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\NamaTagihan;
use App\Models\Kelas;
use App\Models\SiswaPerKelas;
use App\Models\TagihanPerSiswa;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('searchTagihan');

        $tagihanQuery = Tagihan::with(['namaTagihan','tagihanPerSiswa.tahunAjar']);

        $tagihanQuery->whereHas('tagihanPerSiswa.tahunAjar',function($query){
            $query->where('aktif',true);
        });

        if($search){
            $tagihanQuery->whereHas('namaTagihan', function($query) use ($search){
                $query->where('namaTagihan', 'LIKE', "%$search%");
            });
        }

        $tagihan = $tagihanQuery->paginate(10);

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
        $kelas = Kelas::with('tahunAjar')
                    ->whereHas('tahunAjar',function($query){
                        $query->where('aktif',true);
                    })
                    ->get();

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
        $idNamaTagihan = $request->input('namaTagihan');
        $tanggalMulai = $request->input('tanggalMulai');
        $tanggalSelesai = $request->input('tanggalSelesai');
        $hargaBayar = $request->input('hargaBayar');
        $status = $request->input('status');
        $selectKelas = $request->input('checkKelas',[]);
        $selctAllKelas = $request->input('allCheckKelas');

        $kelas = Kelas::with('tahunAjar')
                    ->whereHas('tahunAjar',function($query){
                        $query->where('aktif',true);
                    })->get();

        $dataKelas;
        
        $tahunAjar = TahunAjar::where('aktif',true)->first();

        if($selctAllKelas == 'Semua Kelas'){
            // $temp = array();
            // foreach ($kelas as $val ) {
            //     array_push($temp,$val->namaKelas);
            // }
            // $dataKelas = implode(',',$temp);
            
            $dataKelas = $selctAllKelas;
        }else{
            $temp = array();
            foreach ($selectKelas as $item) {
                $kelasLike = Kelas::with('tahunAjar')
                ->whereHas('tahunAjar', function($query){
                    $query->where('aktif',true);
                })
                ->where('namaKelas','LIKE',$item .'%')->get();
                
                foreach ($kelasLike as $item2) {
                    array_push($temp,$item2->namaKelas);
                }
            }
            $dataKelas = implode(',',$temp);
        }

        // create Tagihan
        $tagihan = Tagihan::create([
            'idNamaTagihan' => $idNamaTagihan,
            'tanggalMulai' => $tanggalMulai,
            'hargaBayar' => $hargaBayar,
            'tanggalSelesai' => $tanggalSelesai,
            'kelas' => $dataKelas,
            'status' => $status
        ]);

        // generate tagihan per siswa
        if($selctAllKelas == 'Semua Kelas'){
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
                        'idSPK' => $item->idSPK,
                        'idTahunAjar' => $tahunAjar->idTahunAjar
                    ]);
                }
            }
        }else{
            foreach ($selectKelas as $item) {
                $kelasLike = Kelas::with('tahunAjar')
                ->whereHas('tahunAjar', function($query){
                    $query->where('aktif',true);
                })
                ->where('namaKelas','LIKE',$item .'%')->get();

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
                            'idSPK' => $item->idSPK,
                            'idTahunAjar' => $tahunAjar->idTahunAjar
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tagihan = Tagihan::with('namaTagihan')->where('idTagihan', $id)->first();
        $namaTagihan = NamaTagihan::get();
        $arrayKelas = [];

        if($tagihan->kelas != "Semua Kelas"){
            $arrayKelas = array_unique(array_filter(explode(' ', preg_replace('/[^0-9]/', ' ', $tagihan->kelas))));
        }

        $data_view=[
            'tagihan'=>$tagihan,
            'namaTagihan'=>$namaTagihan,
            'daftarKelas' =>$arrayKelas,
            'idTagihan' =>$id
        ];

        return view('tagihan.edit',$data_view)->with('judul','Tagihan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get input
        $idNamaTagihan = $request->input('namaTagihan');
        $tanggalMulai = $request->input('tanggalMulai');
        $tanggalSelesai = $request->input('tanggalSelesai');
        $hargaBayar = $request->input('hargaBayar');
        $status = $request->input('status');
        // $selectKelas = $request->input('checkKelas',[]);
        // $selctAllKelas = $request->input('allCheckKelas');

        // // deklarasi array
        // $arrayKelas = [];

        // // get data
        // $tagihan = Tagihan::with('namaTagihan')->where('idTagihan', $id)->first();
        // $kelas = Kelas::orderBy('namaKelas','ASC')->get();

        // if($tagihan->kelas != "Semua Kelas"){
        //     $arrayKelas = array_unique(array_filter(explode(' ', preg_replace('/[^0-9]/', ' ', $tagihan->kelas))));
        // }

        // if($selctAllKelas == 'Semua Kelas'){
            
        //     $dataKelas = $selctAllKelas;
        // }else{
        //     $temp = array();
        //     foreach ($selectKelas as $item) {
        //         $kelasLike = Kelas::where('namaKelas','LIKE',$item .'%')->get();
        //         foreach ($kelasLike as $item2) {
        //             array_push($temp,$item2->namaKelas);
        //         }
        //     }
        //     $dataKelas = implode(',',$temp);
        // }

        
        // // edit Tagihan Per Siswa
        // if($selctAllKelas == 'Semua Kelas' && $tagihan->kelas != "Semua Kelas"){
        //     foreach ($kelas as $value) {
        //         // $siswa = SiswaPerKelas::where('idKelas',$value->idKelas)->get();
        //         foreach ($arrayKelas as $val ) {
        //             $siswaPilihan = SiswaPerKelas::with('kelas')
        //                                         ->whereDoesntHave('kelas', function($query) use ($val) {
        //                                             $query->where('namaKelas', 'like', $val . '%');
        //                                         })
        //                                         ->whereHas('kelas', function($query) use ($value) {
        //                                             $query->where('idKelas', $value->idKelas);
        //                                         })
        //                                         ->get();
                    
        //             foreach ($siswaPilihan as $item) {
        //                 // random number for noTagihan
        //                 $randomNumbers = [];
        
        //                 for ($i = 0; $i < 10; $i++) {
        //                     $randomNumbers[] = random_int(0, 9); // Ganti rentang sesuai kebutuhan Anda
        //                 }
        //                 $randomNumbers = implode('',$randomNumbers);
        //                 $noInvoice= $randomNumbers;
                        
        //                 TagihanPerSiswa::create([
        //                     'noTagihan' => $noInvoice,
        //                     'status' => 'Belum Lunas',
        //                     'idTagihan' => $tagihan->idTagihan,
        //                     'idSPK' => $item->idSPK
        //                 ]);
        //             }
        //         }  
        //     }
        // }else{
        //     if($tagihan->kelas == "Semua Kelas"){
        //         foreach ($selectKelas as $value) {
        //             // $siswa = SiswaPerKelas::where('idKelas',$value->idKelas)->get();
        //             foreach ($kelas as $val ) {
        //                 $siswaPilihan = SiswaPerKelas::with('kelas','tagihanPerSiswa')
        //                                             ->whereDoesntHave('kelas', function($query) use ($value) {
        //                                                 $query->where('namaKelas', 'like', $value . '%');
        //                                             })
        //                                             ->whereHas('kelas', function($query) use ($val) {
        //                                                 $query->where('namaKelas', 'like', $val->namaKelas . '%');
        //                                             })
        //                                             ->get();
                        
        //                 foreach ($siswaPilihan as $item) {
        //                     TagihanPerSiswa::where('idTPS', $item->tagihanPerSiswa[0]->idTPS)->forceDelete();
        //                 }
        //             }  
        //         }
        //     }else{
        //         foreach ($selectKelas as $value) {
        //             foreach ($kelas as $val) {
        //                 $siswaPilihan = SiswaPerKelas::with('kelas','tagihanPerSiswa')
        //                                             ->whereDoesntHave('kelas', function($query) use ($value) {
        //                                                 $query->where('namaKelas', 'like', $value . '%');
        //                                             })
        //                                             ->whereHas('kelas', function($query) use ($val) {
        //                                                 $query->where('namaKelas', 'like', $val->namaKelas . '%');
        //                                             })
        //                                             ->get();
        //                 foreach ($siswaPilihan as $item) {
        //                     TagihanPerSiswa::where('idTPS', $item->tagihanPerSiswa[0]->idTPS)->forceDelete();
        //                 }
        //             }
        //             foreach ($arrayKelas as $val) {
        //                 $siswaPilihan = SiswaPerKelas::with('kelas','tagihanPerSiswa')
        //                                             ->whereDoesntHave('kelas', function($query) use ($value) {
        //                                                 $query->where('namaKelas', 'like', $val . '%');
        //                                             })
        //                                             ->whereHas('kelas', function($query) use ($val) {
        //                                                 $query->where('namaKelas', 'like', $value . '%');
        //                                             })
        //                                             ->get();
                                                    
        //                 foreach ($siswaPilihan as $item) {
        //                     // random number for noTagihan
        //                     $randomNumbers = [];
            
        //                     for ($i = 0; $i < 10; $i++) {
        //                         $randomNumbers[] = random_int(0, 9); // Ganti rentang sesuai kebutuhan Anda
        //                     }
        //                     $randomNumbers = implode('',$randomNumbers);
        //                     $noInvoice= $randomNumbers;
                            
        //                     TagihanPerSiswa::create([
        //                         'noTagihan' => $noInvoice,
        //                         'status' => 'Belum Lunas',
        //                         'idTagihan' => $tagihan->idTagihan,
        //                         'idSPK' => $item->idSPK
        //                     ]);
        //                 }
        //             }
        //         }
        //     }

        //     // foreach ($selectKelas as $item) {
        //     //     $kelasLike = Kelas::where('namaKelas','LIKE',$item .'%')->get();
        //     //     foreach ($kelasLike as $val ) {
        //     //         $siswa = SiswaPerKelas::where('idKelas',$val->idKelas)->get();
                
        //     //         // dd($siswa->idSPK);
        //     //         foreach ($siswa as $item) {
        //     //             // random number for noTagihan
        //     //             $randomNumbers = [];
        
        //     //             for ($i = 0; $i < 10; $i++) {
        //     //                 $randomNumbers[] = random_int(0, 9); // Ganti rentang sesuai kebutuhan Anda
        //     //             }
        //     //             $randomNumbers = implode('',$randomNumbers);
        //     //             $noInvoice= $randomNumbers;
                        
        //     //             TagihanPerSiswa::create([
        //     //                 'noTagihan' => $noInvoice,
        //     //                 'status' => 'Belum Lunas',
        //     //                 'idTagihan' => $tagihan->idTagihan,
        //     //                 'idSPK' => $item->idSPK
        //     //             ]);
        //     //         }
        //     //     }
        //     // }
        // }

        // edit tagihan
        Tagihan::where('idTagihan',$id)
                    ->update([
                        'idNamaTagihan' => $idNamaTagihan,
                        'tanggalMulai' => $tanggalMulai,
                        'hargaBayar' => $hargaBayar,
                        'tanggalSelesai' => $tanggalSelesai,
                        'status' => $status
        ]);

        return redirect('tagihan');
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
        
        $idSPK = SiswaPerKelas::with('tahunAjar')
                                    ->whereHas('tahunAjar',function($query){
                                        $query->where('aktif',true);
                                    })
                                    ->where([
                                        'idSiswa' => $idSiswa,
                                        'idKelas' => $idKelas
                                    ])->first();
        
        $tagihanPerSiswa = TagihanPerSiswa::with('tahunAjar')
                                    ->whereHas('tahunAjar',function($query){
                                        $query->where('aktif',true);
                                    })
                                    ->where([
                                        'idSPK' => $idSPK->idSPK,
                                        'status' => 'Belum Lunas'
                                    ])->get();
        
        $idTagihans = $tagihanPerSiswa->pluck('idTagihan');
        
        $tagihan = Tagihan::with(['namaTagihan','tagihanPerSiswa.tahunAjar'])
                            ->whereHas('tagihanPerSiswa.tahunAjar',function($query){
                                $query->where('aktif',true);
                            })
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

    public function validation(Request $request)
    {
        $rules = [
            'namaTagihan' => 'required',
            'tanggalMulai' => 'required',
            'tanggalSelesai' => 'required',
            'hargaBayar' => 'required|numeric',
            'status' => 'required',
            'checkKelas' => 'required',
            'allCheckKelas' => 'required'
        ];

        $messages = [
            'namaTagihan.required' => 'Nama Tagihan wajib diisi.',
            'tanggalMulai.required' => 'Tanggal Mulai wajib diisi.',
            'tanggalSelesai.required' => 'Tanggal Selesai wajib diisi.',
            'hargaBayar.required' => 'Harga Bayar wajib diisi.',
            'hargaBayar.numeric' => 'Inputan harus bersisi Angka.',
            'status.required' => 'Status wajib diisi.',
            'checkKelas.required' => 'Kelas wajib diisi.',
            'allCheckKelas.required' => 'Kelas wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return response()->json(['success' => 'Formulir valid.']); // Jika validasi berhasil

    }
}