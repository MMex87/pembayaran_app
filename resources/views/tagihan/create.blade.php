@extends('layouts.template')

@section('title', 'Tambah Tagihan')

@section('main')
    <div class="pagetitle">
        <h1>Tambah Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/tagihan">Tagihan</a></li>
                <li class="breadcrumb-item active">Tambah Tagihan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Input Tagihan</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/siswa" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="namaTagihan" class="form-label">Nama Tagihan</label>
                            <select name="namaTagihan" id="namaTagihan" aria-describedby="tagihanHelp" class="form-control">
                                <option value="">-- Pilih Tagihan --</option>
                                @foreach ($namaTagihan as $item)
                                    <option value="{{ $item->idNamaTagihan }}">{{ $item->namaTagihan }}</option>
                                @endforeach
                            </select>
                            <div id="tagihanHelp" class="form-text">Jika Tagihan tidak ada, klik <a
                                    href="/namaTagihan">Tambah Tagihan</a></div>
                        </div>
                        <div class="col-md-12">
                            <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai"
                                value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-12">
                            <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai">
                        </div>
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status Aktif</label>
                            <select name="status" id="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                <option value="semua kelas">semua kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->idKelas }}">{{ $item->namaKelas }}</option>
                                @endforeach
                            </select>
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
