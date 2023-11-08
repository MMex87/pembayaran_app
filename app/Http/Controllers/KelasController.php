<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\Siswa;
use App\Models\SiswaPerKelas;
use Illuminate\Support\Facades\Validator;


class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::with(['tahunAjar'])
                        ->whereHas('tahunAjar',function($query){
                            $query->where('aktif', true);
                        })
                        ->orderBy('namaKelas','ASC')->get();


        $view_data = [
            'kelas' => $kelas
        ];

        $judul = "Kelas";
        return view('kelas.index', $view_data)->with('judul',$judul);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $judul = "Kelas";
        return view('kelas.create')->with('judul',$judul);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tahunAjar = TahunAjar::where('aktif',true)->first();
        $namaKelas = $request->input('namaKelas');
        $waliKelas = $request->input('waliKelas');
        $email = $request->input('emailWaliKelas');

        Kelas::create([
            'namaKelas' => $namaKelas,
            'waliKelas' => $waliKelas,
            'emailWaliKelas' => $email,
            'idTahunAjar' => $tahunAjar->idTahunAjar
        ]);

        return redirect('kelas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $kelas = Kelas::with(['tahunAjar'])
                        ->whereHas('tahunAjar',function($query){
                            $query->where('aktif', true);
                        })->where('idKelas',$id)->orderBy('namaKelas','ASC')->first();
        
        $siswa = Siswa::with(['kelas.tahunAjar','golongan'])
                        ->whereHas('kelas.tahunAjar',function($query){
                                        $query->where('aktif', true);
                                    })    
                        ->where([
                            'status'=>'aktif',
                            'idKelas' => $kelas->idKelas
                        ])->orderBy('namaSiswa','ASC')->paginate(10);
        

        $judul = "Kelas";
        

        $view_data=[
            'kelas' => $kelas,
            'siswa' => $siswa,
            'idKelas' => $id,
        ];
        
        return view('kelas.show',$view_data)->with('judul',$judul);
    }

    public function search(Request $request, $id)
    {
        $search = $request->input('searchKelas');
        $kelas = Kelas::with(['tahunAjar'])
                        ->whereHas('tahunAjar',function($query){
                            $query->where('aktif', true);
                        })->where('idKelas',$id)->orderBy('namaKelas','ASC')->first();
        
        $siswaQuery = Siswa::with(['kelas.tahunAjar'])
                        ->whereHas('kelas.tahunAjar',function($query){
                            $query->where('aktif', true);
                        })
                        ->where([
                            'status'=>'aktif',
                            'idKelas' => $id
                        ])->orderBy('namaSiswa','ASC');

        if($search){
            $siswaQuery->where(function($query) use ($search) {
                $query  ->where('namaSiswa', 'LIKE', "%$search%")
                        ->orWhere('nik', 'LIKE', "%$search%");
            });
        }

        $siswa = $siswaQuery->paginate(10);

        $judul = "Kelas";

        $view_data=[
            'kelas' => $kelas,
            'siswa' => $siswa,
            'idKelas' => $id
        ];
        
        return view('kelas.show',$view_data)->with('judul',$judul);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = $kelas = Kelas::with(['tahunAjar'])
                        ->whereHas('tahunAjar',function($query){
                            $query->where('aktif', true);
                        })->where('idKelas',$id)->orderBy('namaKelas','ASC')->first();;

        $judul = 'Kelas';

        $view_data=[
            'kelas'=> $kelas
        ];

        return view('kelas.edit',$view_data)->with('judul',$judul);
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
        $nama = $request->input('namaKelas');
        $waliKelas = $request->input('waliKelas');
        $email = $request->input('emailWaliKelas');

        Kelas::where('idKelas',$id)
            ->update([
                'namaKelas' => $nama,
                'waliKelas' => $waliKelas,
                'emailWaliKelas' => $email
            ]);
        
        return redirect('kelas');
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

    public function validation(Request $request)
    {
        $rules = [
            'namaKelas' => 'required|max:2|alpha_num|uppercase|unique:App\Models\Kelas,namaKelas',
            'waliKelas' => 'required|max:255',
            'emailWaliKelas' => 'required|email',
        ];

        $messages = [
            'namaKelas.required' => 'Nama kelas wajib diisi.',
            'namaKelas.max' => 'Nama kelas tidak di spasi',
            'namaKelas.alpha_num' => 'Nama Kelas harus dari angka dan alfabet - Ex: 1A',
            'namaKelas.uppercase' => 'Nama Kelas harus huruf Capital',
            'namaKelas.unique' => 'Nama Kelas sudah ada.',
            'waliKelas.required' => 'Nama wali kelas wajib diisi.',
            'emailWaliKelas.required' => 'Email wali kelas wajib diisi.',
            'emailWaliKelas.email' => 'Format email tidak valid.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return response()->json(['success' => 'Formulir valid.']); // Jika validasi berhasil

    }

}