<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('searchTahun');

        $tahunQuery = TahunAjar::orderBy('idTahunAjar','DESC');

        if($search){
                $tahunQuery->where('tahun', 'LIKE', "%$search%");
        }
        
        $tahunAjar = $tahunQuery->paginate(5);

        $tempTahun = explode('/', $tahunAjar[0]->tahun);

        $handleTambah = false;

        if($tempTahun[0] == now()->format('Y')){
            $handleTambah = false;
        }else{
            $handleTambah = true;
        }

        $judul = "Dashboard";
        return view('dashboard.index',['tahunAjar' => $tahunAjar,'handleTambah' => $handleTambah])->with('judul',$judul);
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
        $tahunAjar = TahunAjar::orderBy('idTahunAjar', 'DESC')->first();
        $tempTahun = explode('/' , $tahunAjar->tahun);

        $tahunKedua = $tempTahun[1];

        $hasilTahun = $tahunKedua . '/'.((int)$tahunKedua + 1);

        TahunAjar::create([
            'tahun' => $hasilTahun,
            'aktif' => false
        ]);

        return redirect()->back();
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
        $aktif = $request->input('aktif');
        $tahunAktif = TahunAjar::where('aktif' , true)->first();
        // dd($tahunAktif->idTahunAjar);

        TahunAjar::where('idTahunAjar', $tahunAktif->idTahunAjar)->update([
            'aktif' => false
        ]);

        TahunAjar::where('idTahunAjar', $id)->update([
            'aktif' => $aktif
        ]);

        return redirect()->back();

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