<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\SiswaPerKelas;
use App\Models\TahunAjar;
use App\Models\TagihanPerSiswa;
use App\Models\Tagihan;
use App\Imports\ImportExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Golongan;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('searchSiswa');
        $siswaQuery = SiswaPerKelas::with(['siswa','siswa.golongan', 'kelas','tahunAjar'])
                                ->whereHas('tahunAjar', function($query){
                                    $query->where('aktif',true);
                                })
                                ->join('siswa', 'siswa_per_kelas.idSiswa', '=', 'siswa.idSiswa')
                                ->where('siswa.status', 'aktif')
                                ->orderByDesc('siswa.idSiswa');

        if($search){
            $siswaQuery->where(function($query) use ($search) {
                $query  ->where('namaSiswa', 'LIKE', "%$search%")
                        ->orWhere('nik', 'LIKE', "%$search%");
            });
        }

        $siswa = $siswaQuery->paginate(10);

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
        $kelas = Kelas::with('tahunAjar')
                            ->whereHas('tahunAjar', function($query){
                                $query->where('aktif', true);
                            })->get();

        $golongan = Golongan::get();

        $view_data=[
            'kelas' => $kelas,
            'golongan' => $golongan
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
        $golongan = $request->input('golongan');
        
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
            'status' => 'aktif',
            'idGolongan' => $golongan
        ]);
        
        $tahunAjar = TahunAjar::where('aktif', true)->first();

        SiswaPerKelas::create([
            'idSiswa' => $siswa->idSiswa,
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
        $siswa = Siswa::with('siswaPerKelas.tahunAjar','golongan')
                        ->whereHas('siswaPerKelas.tahunAjar', function($query){
                            $query->where('aktif',true);
                        })
                        ->where('idSiswa',$id)->first();
        $kelas = Kelas::with('tahunAjar')
                        ->whereHas('tahunAjar', function($query){
                            $query->where('aktif',true);
                        })
                        ->where('idKelas',$siswa->idKelas)->first();
        $data_kelas = Kelas::with('tahunAjar')
                        ->whereHas('tahunAjar', function($query){
                            $query->where('aktif',true);
                        })->get();
        $tagihan = TagihanPerSiswa::with(['tagihan.namaTagihan', 'transaksi','siswaPerKelas.siswa','siswaPerKelas','tahunAjar'])
                                    ->whereHas('siswaPerKelas', function($query) use ($id) {
                                                    $query->where('idSiswa', $id);
                                                })
                                    ->WhereHas('tahunAjar',function($query){
                                        $query->where('aktif',true);
                                    })
                                    ->orderByDESC('idTPS')
                                    ->paginate(5);
                                    
        $golongan = Golongan::get();

        $view_data=[
            'siswa' => $siswa,
            'namaKelas' => $kelas->namaKelas,
            'data_kelas' => $data_kelas,
            'kelas' => $kelas,
            'tagihan' => $tagihan,
            'golongan' => $golongan
        ];
        return view('siswa.detail',$view_data)->with('judul','Siswa');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateKelas($idSiswa, $idSPK, Request $request)
    {
        $idKelas = $request->input('kelas');
        // $spkKelasBaru = SiswaPerKelas::where('idKelas',$idKelas)->first();
        // $tps = TagihanPerSiswa::where('idSPK',$idSPK)->get();
        // $tpskelasBaru = TagihanPerSiswa::where('idSPK',$spkKelasBaru->idSPK)->get();
        
        // foreach ($tpskelasBaru as $val) {
        //     for ($i = 0;$i< $tpskelasBaru->count();$i++) {
        //         if($tps[$i]->idTagihan == null){
        //             dd("tidak ganti");
        //         }else{
        //             dd('ganti');
        //         }
        //     }
        // }
            
        SiswaPerKelas::where('idSPK', $idSPK)->update([
            'idKelas' => $idKelas
        ]);
        Siswa::where('idSiswa', $idSiswa)->update([
            'idKelas' => $idKelas
        ]);


        return redirect("/siswa/$idSiswa");
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
        $namaWali = $request->input('waliSiswa');
        $alamat = $request->input('alamat');
        $nomerWali = $request->input('noWali');
        $nomerKIP = $request->input('noKIP');
        $golongan = $request->input('golongan');
        
        $siswa = Siswa::with('siswaPerKelas.tahunAjar')
                    ->whereHas('siswaPerKelas.tahunAjar',function($query){
                        $query->where('aktif',true);
                    })
                    ->where('idSiswa',$id)->first();
        
        Siswa::where('idSiswa',$id)->update([
            'namaSiswa' => $namaSiswa,
            'tanggalLahir' => $tanggalLahir,
            'nik' => $nik,
            'jenisKelamin' => $jenisKelamin,
            'noHP' => $nomerWali,
            'alamat' => $alamat,
            'noKIP' => $nomerKIP,
            'namaWali' => $namaWali,
            'idGolongan' => $golongan
        ]);

        // if($idKelas != $siswa->idKelas){
        //     SiswaPerKelas::where('idSiswa',$id)->update([
        //         'idKelas' => $idKelas
        //     ]);
        // }

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
        // Ambil nilai idKelas dari input form atau sumber lain
        $idKelas = $request->input('kelasExcel');

        // Simpan nilai idKelas ke dalam properti $idKelas pada model Excel
        $import = new ImportExcel();
        $import->idKelas = $idKelas;
        
        // Lakukan proses impor menggunakan Maatwebsite\Excel
        Excel::import($import, $request->file('inputExcel'));
        
        // Session::flash('successExcel', 'Data Import Siswa Berhasil Tersimpan');

        return redirect()->back()->with('successExcel', 'Data Import Siswa Berhasil Tersimpan');
    }

    public function validation(Request $request)
    {
        $rules = [
            'namaSiswa' => 'required|max:255|uppercase',
            'nik' => 'required|min_digits:16|max_digits:16',
            'tanggalLahir' => 'required',
            'jenisKelamin' => 'required',
            'kelas' => 'required',
            'kelasExcel' => 'required',
            'alamat' => 'required',
            'waliSiswa' => 'required|max:255',
            'inputExcel' => 'required',
            'golongan' => 'required'
        ];

        $messages = [
            'namaSiswa.required' => 'Nama Siswa wajib diisi.',
            'namaSiswa.max' => 'Nama Siswa terlalu panjang.',
            'namaSiswa.uppercase' => 'Nama Siswa harus huruf Capital.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.max_digits' => 'NIK lebih dari 16 digit.',
            'nik.min_digits' => 'NIK kurang dari 16 digit.',
            'tanggalLahir.required' => 'Tanggal Lahir Siswa wajib diisi.',
            'jenisKelamin.required' => 'Jenis Kelamin Siswa wajib diisi.',
            'kelas.required' => 'Kelas Siswa wajib diisi.',
            'kelasExcel.required' => 'Kelas Siswa wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'waliSiswa.required' => 'Nama Wali wajib diisi.',
            'waliSiswa.max' => 'Nama Wali terlalu panjang.',
            'inputExcel.required' => 'Upload excel wajib diisi',
            'golongan.required' => 'Golongan wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return response()->json(['success' => 'Formulir valid.']); // Jika validasi berhasil

    }
}