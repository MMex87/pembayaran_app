<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;
use App\Models\SiswaPerKelas;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TagihanPerSiswa;
use App\Models\Transaksi;
use Carbon\Carbon;

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

        // dd($tahunAjar);
        $spk = SiswaPerKelas::with('tahunAjar')
                            ->whereHas('tahunAjar',function($query){
                                $query->where('aktif',true);
                            })->get();
        $handleNaikKelas=false;
        if($spk->isEmpty()){
            $handleNaikKelas = true;
        }else{
            $handleNaikKelas = false;
        }

        $tempTahun = explode('/', $tahunAjar[0]->tahun);

        $handleTambah = false;

        if($tempTahun[0] == now()->format('Y')){
            $handleTambah = false;
        }else{
            $handleTambah = true;
        }

        // detail Dashboard

        $siswa = Siswa::with('siswaPerKelas.tahunAjar')
                        ->whereHas('siswaPerKelas.tahunAjar',function($query){
                            $query->where('aktif',true);
                        })->count();

        $tagihan = Tagihan::with('tagihanPerSiswa.tahunAjar')
                        ->whereHas('tagihanPerSiswa.tahunAjar',function($query){
                            $query->where('aktif',true);
                        })->count();
        
        $tps = TagihanPerSiswa::with('tahunAjar')
                            ->whereHas('tahunAjar',function($query){
                                $query->where('aktif',true);
                            })
                            ->where('status','Belum Lunas')->count();

        $transaksi = Transaksi::with(['tagihanPerSiswa.tahunAjar','tagihanPerSiswa.tagihan','tagihanPerSiswa.siswaPerKelas.siswa'])
                            ->whereHas('tagihanPerSiswa.tahunAjar',function($query){
                                $query->where('aktif',true);
                            })->limit(6)->orderBy('idTransaksi','DESC')->get();
        
        $transaksi->map(function($item, $key) {
            $waktu_transaksi = Carbon::parse($item->updated_at);
            $selisih = $waktu_transaksi->diffForHumans();
            $item->waktu_hitung = $selisih;
            return $item;
        });

        $judul = "Dashboard";
        return view('dashboard.index',[
            'tahunAjar' => $tahunAjar,
            'handleTambah' => $handleTambah,
            'handleNaikKelas' => $handleNaikKelas,
            'siswa' => $siswa,
            'tagihan' => $tagihan,
            'tps' => $tps,
            'transaksi' =>$transaksi
            ])->with('judul',$judul);
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

    public function naikKelas()
    {
        
        $tahunAjarBaru = TahunAjar::where('aktif',true)->first();
        $kelas = Kelas::with('tahunAjar')
                    ->whereHas('tahunAjar',function($query){
                        $query->where('aktif',true);
                    })->get();

        $spk = SiswaPerKelas::with('kelas')->where('idTahunAjar',$tahunAjarBaru->idTahunAjar)->get();

        $handleNaikKelas = false;
        $handlePage = false;
        if($kelas->isEmpty()){
            $handleNaikKelas = false;
        }else{
            $handleNaikKelas = true;
        }

        if($spk->isEmpty()){
            $handlePage = false;
        }else{
            $handlePage = true;
        }

        if($handlePage == true){
            return redirect('/');
        }else{
            return view('dashboard.naikKelas',['naikKelas' => $handleNaikKelas])->with('judul','Dashboard');
        }

    }

    public function generateKelas()
    {
        $tahunAjarBaru = TahunAjar::where('aktif',true)->first();
        
        $idTahunAjarLama = ($tahunAjarBaru->idTahunAjar - 1);

        $kelasLama = Kelas::where('idTahunAjar', $idTahunAjarLama)->get();
        // dd($kelasLama);

        foreach ($kelasLama as $value) {
            Kelas::create([
                'namaKelas' => $value->namaKelas,
                'waliKelas' => $value->waliKelas,
                'emailWaliKelas' => $value->emailWaliKelas,
                'idTahunAjar' => $tahunAjarBaru->idTahunAjar
            ]);
        }

        return redirect()->back();
    }

    public function storeNaikKelas()
    {
        $tahunAjarBaru = TahunAjar::where('aktif',true)->first();
        
        $idTahunAjarLama = ($tahunAjarBaru->idTahunAjar - 1);

        $spk = SiswaPerKelas::with('kelas')->where('idTahunAjar',$idTahunAjarLama)->get();

        $siswa = Siswa::with(['siswaPerKelas.kelas','siswaPerKelas.tahunAjar'])
                    ->whereHas('siswaPerKelas.tahunAjar', function($query) use ($idTahunAjarLama){
                        $query->where('idTahunAjar',$idTahunAjarLama);
                    })->get();

        $kelas = Kelas::where('idTahunAjar',$tahunAjarBaru->idTahunAjar)->get();
        
        foreach ($siswa as $value) {
        
            $pisahKelas = str_split($value->siswaPerKelas[0]->kelas->namaKelas);
            $namaKelas = ($pisahKelas[0] + 1).$pisahKelas[1];
            
            $idKelas = Kelas::with('tahunAjar')
                            ->whereHas('tahunAjar',function($query){
                                $query->where('aktif',true);
                            })->where('namaKelas',$namaKelas)->first();
                            dd($idKelas);
                            
            if($pisahKelas[0] == 6){
                Siswa::where('idSiswa',$value->idSiswa)->update([
                    'idKelas' => null,
                ]);
            }else{
                Siswa::where('idSiswa',$value->idSiswa)->update([
                    'idKelas' => $idKelas->idKelas,
                    'status' => 'alumni'
                ]);
                SiswaPerKelas::create([
                    'idKelas' => $idKelas->idKelas,
                    'idSiswa' => $value->idSiswa,
                    'idTahunAjar' =>$tahunAjarBaru->idTahunAjar
                ]);
            }
        }
        return redirect('/');
    }
}