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

    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambahkan Siswa Berdasarkan</h5>

                <!-- Default Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Tambahkan
                            Manual</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Import Excel</button>
                    </li>

                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
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
                                            <option value="" selected>-- Pilih Jenis Kelamin --</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <select name="kelas" id="kelas" class="form-control">
                                            <option value="" selected>-- Pilih Kelas --</option>
                                            @foreach ($kelas as $value)
                                                <option value="{{ $value->idKelas }}">{{ $value->namaKelas }}
                                                </option>
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
                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Form Input Excel</h5>

                                <form action="/siswaImport" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <select name="kelas" id="kelas" class="form-control">
                                            <option value="" selected>-- Pilih Kelas --</option>
                                            @foreach ($kelas as $value)
                                                <option value="{{ $value->idKelas }}">{{ $value->namaKelas }}
                                                </option>
                                            @endForeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="inputExcel" class="form-label">Upload File Excel</label>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" id="inputExcel" name="inputExcel"
                                                accept=".xlsx, .xls, .csv">
                                            <label class="input-group-text" for="inputExcel">Upload</label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- End Default Tabs -->

            </div>
        </div>
    </div>

    @if (Session::has('successExcel'))
        <script>
            $(document).ready(function() {
                swal.close();
                Swal.fire({
                    icon: 'success',
                    title: '{{ Session::get('successExcel') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
        </script>
        @php(session()->forget('successExcel'))
    @endif


@endsection
