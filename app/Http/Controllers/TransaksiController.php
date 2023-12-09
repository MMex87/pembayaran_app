<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TagihanPerSiswa;
use App\Models\SiswaPerKelas;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PembayaranSekolahEmail;
use Alert;
use PDF;
use View;

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
        $kelas = Kelas::with('tahunAjar')
                        ->whereHas('tahunAjar',function($query){
                            $query->where('aktif',true);
                        })
                        ->orderBy('namaKelas','ASC')->get();
        $tahun;
        $invoice;
        $daftarTagihan;
        $tagihan = TagihanPerSiswa::with(['tagihan.namaTagihan', 'transaksi','siswaPerKelas.siswa','tahunAjar','transaksi.users'])
                                        ->whereHas('tahunAjar',function($query){
                                            $query->where('aktif',true);
                                        })
                                        ->where('status','Cart')
                                        ->get();

        // dd($tagihan);
        
        // dd($tagihan);
        if($tagihan->isNotEmpty()){
            $tahunAjar = $tagihan[0]->tahunAjar->tahun;
            $temp = explode('/',$tahunAjar);
            $tahun = implode('-',$temp);
            $invoice = $tagihan[0]->transaksi->invoice;
            $idSPK = $tagihan[0]->idSPK;
            $daftarTagihan = TagihanPerSiswa::with('tagihan.namaTagihan','tahunAjar','transaksi.users')
                                            ->whereHas('tahunAjar',function($query){
                                                $query->where('aktif',true);
                                            })
                                            ->where(['idSPK'=>$idSPK, 'status'=>'Belum Lunas'])->get();
        }else{
            $tahun = '';
            $invoice = 'INV'.$date;
            $daftarTagihan = '';
        }
        $user = Users::orderBy('idUser','DESC')->get();

        $view_data=[
            'kelas' => $kelas,
            'invoice' => $invoice,
            'tagihan' => $tagihan,
            'tahun' => $tahun,
            'users' => $user,
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
        $idUser = $request->input('user');
        
        $siswa = Siswa::with('siswaPerKelas.tahunAjar')
                        ->whereHas('siswaPerKelas.tahunAjar',function($query){
                            $query->where('aktif',true);
                        })
                        ->where([
                            'idKelas' => $idKelas,
                            'namaSiswa' => $namaSiswa
                        ])->first();
        $idSiswa = $siswa->idSiswa;

        $spk = SiswaPerKelas::with('tahunAjar')
                            ->whereHas('tahunAjar',function ($query) {
                                $query->where('aktif',true);
                            })
                            ->where([
                                'idSiswa' => $idSiswa,
                                'idKelas' => $idKelas
                            ])->first();

        $tps = TagihanPerSiswa::with('tahunAjar')
                                ->whereHas('tahunAjar',function($query){
                                    $query->where('aktif',true);
                                })
                                ->where([
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
            'idTPS' => $tps->idTPS,
            'idUser' => $idUser
        ]);
        
        Session::flash('success', 'Checkout Berhasil');
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
    public function update(Request $request, $id)
    {
        TagihanPerSiswa::where([
                                'idTPS' => $id
                            ])->update([
                                'status' => 'Belum Lunas'
                            ]);

        return redirect('pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    
    public function printNota()
    {
        $date = date('d-m-Y');
        $tagihan = TagihanPerSiswa::with(['tagihan.namaTagihan', 'transaksi','siswaPerKelas.siswa','tahunAjar','siswaPerKelas.kelas','tahunAjar','transaksi.users'])
                                    ->whereHas('tahunAjar',function($query){
                                        $query->where('aktif',true);
                                    })
                                    ->where('status','Cart')
                                    ->get();

        if (!$tagihan->isEmpty()) {
            $invoice = $tagihan[0]->transaksi->invoice;
            $dataNama = $tagihan[0]->siswaPerKelas->siswa->namaSiswa;
            $tempNama = explode(' ', $dataNama);
            $nama = implode('', $tempNama);
            // dd($nama);
            $kelas = $tagihan[0]->siswaPerKelas->kelas->namaKelas;
            $tahunAjar = $tagihan[0]->siswaPerKelas->tahunAjar->tahun;
            $temp = explode('/',$tahunAjar);
            $tahun = implode('-',$temp);
            $staf = $tagihan[0]->transaksi->users->nama;
            
            
            // Inisialisasi TCPDF
            $pdf = new \TCPDF();

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Hapus margin kiri
            $pdf->SetMargins(5, 0, 0);
        
            $pdf->AddPage('P', array(57, 120));
            // $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

            // Tambahkan konten ke PDF
            $pdf->SetFont('','',12);
            $pdf->Cell(0, 10, 'Nota Pembayaran', 0, 1, 'C');
            $pdf->SetFont('','',7);
            // $pdf->SetXY(0, 20);
            $pdf->Cell(0, 5, 'Nomor Nota: ' . $invoice, 0, 1, 'L');
            // $pdf->SetXY(0, 25);
            $pdf->Cell(0, 5, 'Tanggal: ' . $date, 0, 1, 'L');
            // $pdf->SetXY(0, 30);
            $pdf->Cell(0, 5, 'Nama: ' . $dataNama, 0, 1, 'L');
            // $pdf->SetXY(5, 35);
            $pdf->Cell(0, 5, 'Kelas: ' . $kelas, 0, 1, 'L');

            $pdf->Cell(0, 5, 'Admin: ' . $staf, 0, 1, 'L');
            
            $pdf->Cell(0, 5, '', 0, 1, 'L');
            // Tabel tagihan
            $pdf->SetFont('','',7);
            $pdf->SetFillColor(255, 255, 255);
            // $pdf->SetXY(0, 43);
            $pdf->Cell(20, 5, 'Nama Tagihan', 0, 0, 'C',1);
            $pdf->Cell(15, 5, 'No. Tagihan', 0, 0, 'C',1);
            $pdf->Cell(15, 5, 'Harga Bayar', 0, 1, 'C',1);
            
            // $pdf->SetXY(5, 40);
            $total = 0;
            foreach ($tagihan as $value) {
                $namaTagihan = $value->tagihan->namaTagihan->namaTagihan;
                if(strlen($namaTagihan) >= 15){
                    $pdf->SetFont('','',5);
                    $pdf->Cell(20, 5, $value->tagihan->namaTagihan->namaTagihan, 0, 0, 'L');
                }elseif(strlen($namaTagihan) >= 12){
                    $pdf->SetFont('','',6);
                    $pdf->Cell(20, 5, $value->tagihan->namaTagihan->namaTagihan, 0, 0, 'L');
                }else{
                    $pdf->SetFont('','',7);
                    $pdf->Cell(20, 5, $value->tagihan->namaTagihan->namaTagihan, 0, 0, 'L');
                }
                $pdf->SetFont('','',7);
                $pdf->Cell(15, 5, $value->noTagihan, 0, 0, 'C');
                $pdf->Cell(15, 5, $value->tagihan->hargaBayar, 0, 1, 'R');
                $total += $value->tagihan->hargaBayar;
            }
            
            // $pdf->SetXY(5, 45);
            // Total
            $pdf->Cell(35, 5, 'Total', 0, 0, 'R');
            $pdf->Cell(15, 5, $total, 0, 1, 'R');

            $directoryPath = public_path('pdf/'.$tahun.'/'.$kelas.'/');

            // Periksa apakah direktori sudah ada
            if (!File::exists($directoryPath)) {
                // Jika belum ada, buat direktori baru
                File::makeDirectory($directoryPath, 0777, true, true);

                $pdfPath = storage_path('../public/pdf/'.$tahun.'/'.$kelas.'/'.$nama.'.pdf');
                $pdf->Output($pdfPath, 'F');
            } else {
                $pdfPath = storage_path('../public/pdf/'.$tahun.'/'.$kelas.'/'.$nama.'.pdf');
                $pdf->Output($pdfPath, 'F');
            }

            
            // Rubah Status
            
            foreach ($tagihan as $val) {
                TagihanPerSiswa::where([
                                'idTPS' => $val->idTPS
                            ])->update([
                                'status' => 'Lunas'
                            ]);
            }

            // Simpan atau kirimkan PDF sebagai respons
            Session::flash('print', 'pdf/'.$tahun.'/'.$kelas.'/'.$nama.'.pdf');
            Session::flash('successBayar', 'Pembayaran Berhasil');

            sleep(5);

            try {
                // Kirim email
                $receiverEmail = $tagihan[0]->siswaPerKelas->kelas->emailWaliKelas;
                $receiverName = $tagihan[0]->siswaPerKelas->kelas->waliKelas; 
    
                $data = [
                    'namaSiswa' => $tagihan[0]->siswaPerKelas->siswa->namaSiswa,
                    'tagihan' => $tagihan, // Ganti dengan jumlah tagihan yang sesuai// Ganti dengan tanggal batas pembayaran yang sesuai
                ];
    
                $pdfAttachmentPath = public_path('pdf/'.$tahun.'/'.$kelas.'/'.$nama.'.pdf'); // Ganti dengan lokasi file PDF faktur/tagihan
                
                Mail::to($receiverEmail)->send(new PembayaranSekolahEmail($data, $pdfAttachmentPath, $receiverName));
            } catch (\Throwable $th) {
                // Simpan atau kirimkan PDF sebagai respons
                Session::flash('gagal-email', $th->getMessage());
            }

            return redirect('pembayaran');
        } else {
            return 'Tagihan tidak ditemukan';
        }
    }

    public function validation(Request $request)
    {
        $rules = [
            'namaTagihan' => 'required',
            'siswa' => 'required|exists:App\Models\Siswa,namaSiswa',
            'kelas' => 'required',
            'user' => 'required',
        ];

        $messages = [
            'namaTagihan.required' => 'Nama Tagihan wajib diisi.',
            'siswa.required' => 'Siswa wajib diisi.',
            'siswa.exists' => 'Nama Siswa tidak ada di dalam Database.',
            'kelas.required' => 'Kelas wajib diisi.',
            'user.required' => 'User wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return response()->json(['success' => 'Formulir valid.']); // Jika validasi berhasil

    }

    
}