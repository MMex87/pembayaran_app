<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::orderBy('namaKelas','ASC')->get();


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
        $namaKelas = $request->input('namaKelas');
        $waliKelas = $request->input('waliKelas');
        $email = $request->input('emailWaliKelas');

        Kelas::create([
            'namaKelas' => $namaKelas,
            'waliKelas' => $waliKelas,
            'emailWaliKelas' => $email,
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
        $kelas = Kelas::where('idKelas',$id)->orderBy('namaKelas','ASC')->first();
        
        $siswa = Siswa::with('kelas')->where([
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
        $kelas = Kelas::where('idKelas',$id)->orderBy('namaKelas','ASC')->first();
        
        $siswaQuery = Siswa::with('kelas')
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
        $kelas = Kelas::where('idKelas',$id)->first();

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

}