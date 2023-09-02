@extends('layouts.template')

@section('title', 'Edit Kelas')

@section('main')
    <div class="pagetitle">
        <h1>Edit Kelas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/kelas">Kelas</a></li>
                <li class="breadcrumb-item active">Edit Kelas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Edit Kelas</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/kelas/{{ $kelas->idKelas }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="col-md-12">
                            <label for="namaKelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="namaKelas" name="namaKelas"
                                value="{{ $kelas->namaKelas }}">
                        </div>
                        <div class="col-md-12">
                            <label for="waliKelas" class="form-label">Wali Kelas</label>
                            <input type="text" class="form-control" id="waliKelas" name="waliKelas"
                                value="{{ $kelas->waliKelas }}">
                        </div>
                        <div class="col-md-12">
                            <label for="emailWaliKelas" class="form-label">Email Wali Kelas</label>
                            <input type="email" class="form-control" id="emailWaliKelas" name="emailWaliKelas"
                                value="{{ $kelas->emailWaliKelas }}">
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
