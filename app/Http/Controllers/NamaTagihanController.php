<?php

namespace App\Http\Controllers;

use App\Models\NamaTagihan;
use Illuminate\Http\Request;

class NamaTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $namaTagihan = NamaTagihan::paginate(5);
        $data_view= [
            'namaTagihan' => $namaTagihan
        ];
        return view('tagihan.nama_tagihan.index',$data_view)->with('judul','Tagihan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tagihan.nama_tagihan.create')->with('judul','Tagihan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNama_TagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama_Tagihan = $request->input('namaTagihan');

        NamaTagihan::create([
            'namaTagihan' => $nama_Tagihan
        ]);

        return redirect('namaTagihan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nama_Tagihan  $nama_Tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Nama_Tagihan $nama_Tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nama_Tagihan  $nama_Tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Nama_Tagihan $nama_Tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNama_TagihanRequest  $request
     * @param  \App\Models\Nama_Tagihan  $nama_Tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $namaTagihan = $request->input('namaTagihan');

        NamaTagihan::where('idNamaTagihan',$id)->update([
            'namaTagihan' => $namaTagihan
        ]); 

        return redirect('namaTagihan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nama_Tagihan  $nama_Tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NamaTagihan::where('idNamaTagihan',$id)->delete();

        return redirect('namaTagihan');
    }
}