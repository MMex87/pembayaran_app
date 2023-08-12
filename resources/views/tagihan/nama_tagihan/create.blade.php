@extends('layouts.template')

@section('title', 'Tambah Tagihan')

@section('main')
    <div class="pagetitle">
        <h1>Tambah Nama Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/tagihan">Tagihan</a></li>
                <li class="breadcrumb-item"><a href="/tagihan/create">Tambah Tagihan</a></li>
                <li class="breadcrumb-item"><a href="/namaTagihan">Nama Tagihan</a></li>
                <li class="breadcrumb-item active">Tambah Nama Tagihan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Input Nama Tagihan</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/namaTagihan" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="namaTagihan" class="form-label">Nama Tagihan</label>
                            <input type="text" class="form-control" id="namaTagihan" name="namaTagihan">
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
