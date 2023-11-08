<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagihanPerSiswa;

class TagihanPerSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $queryTagihan = TagihanPerSiswa::with(['tagihan.namaTagihan', 'transaksi', 'siswaPerKelas.siswa','tahunAjar'])
                                    ->whereHas('tahunAjar',function($query){
                                        $query->where('aktif',true);
                                    });

        if($search){
            $queryTagihan->whereHas('tagihan.namaTagihan',function($query) use ($search){
                $query->where('namaTagihan','LIKE', "%$search%");
            });
            $queryTagihan->orWhereHas('siswaPerKelas.siswa', function($query) use ($search){
                $query->where('namaSiswa', 'LIKE', "%$search%");
            });
            $queryTagihan->orWhere('status','LIKE', "$search%");
        }

        $tagihan = $queryTagihan->orderBy('idSPK','ASC')->paginate(10);

        $view_data=[
            'tagihan' => $tagihan
        ];
        
        return view('tagihan.tagihan_per_siswa.index',$view_data)->with('judul','TagihanSiswa');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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