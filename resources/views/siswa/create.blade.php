@extends('layouts.template')

@section('title', 'Tambah Siswa')

@section('main')
    <div class="pagetitle">
        <h1>Tambah Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/siswa">Siswa</a></li>
                <li class="breadcrumb-item active">Tambah Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Input Siswa</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/siswa" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="namaSiswa" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="namaSiswa" name="namaSiswa">
                        </div>
                        <div class="col-md-12">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>
                        <div class="col-md-12">
                            <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir">
                        </div>
                        <div class="col-md-12">
                            <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenisKelamin" id="jenisKelamin" class="form-control">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control">
                                @foreach ($kelas as $value)
                                    <option value="{{ $value->idkelas }}">{{ $value->namaKelas }}</option>
                                @endForeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="15" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="waliSiswa" class="form-label">Nama Wali</label>
                            <input type="text" class="form-control" id="waliSiswa" name="waliSiswa">
                        </div>
                        <div class="col-md-12">
                            <label for="noKIP" class="form-label">nomer KIP</label>
                            <input type="text" class="form-control" id="noKIP" name="noKIP">
                        </div>
                        <div class="col-md-12">
                            <label for="noWali" class="form-label">Nomer Wali Siswa</label>
                            <input type="text" class="form-control" id="noWali" name="noWali">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Multi Columns Form -->

                </div>
            </div>
        </div>
    </div>
@endsection
