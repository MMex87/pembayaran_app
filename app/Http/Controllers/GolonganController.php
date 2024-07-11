<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use Illuminate\Support\Facades\Validator;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $golongan = Golongan::where('namaGolongan', 'LIKE', "%$search%")->paginate(2);
        } else {
            $golongan = Golongan::paginate(2);
        }

        $data_view = [
            'golongan' => $golongan
        ];
        return view('siswa.golongan.index', $data_view)->with('judul', 'Siswa');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa.golongan.create')->with('judul', 'Siswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $namaGolongan = $request->input('namaGolongan');

        Golongan::create([
            'namaGolongan' => $namaGolongan
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
        $namaGolongan = $request->input('namaGolongan');

        Golongan::where('idGolongan', $id)->update([
            'namaGolongan' => $namaGolongan
        ]);

        return redirect('golongan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Golongan::where('idGolongan', $id)->delete();

        return redirect('golongan');
    }

    public function validation(Request $request)
    {
        $rules = [
            'namaGolongan' => 'required'
        ];

        $messages = [
            'namaGolongan.required' => 'Nama Golongan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return response()->json(['success' => 'Formulir valid.']); // Jika validasi berhasil

    }
    public function getGolongan()
    {
        $golongan = Golongan::orderBy('idGolongan', 'desc')->first();

        return json_encode($golongan);
    }
}