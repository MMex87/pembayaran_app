@extends('layouts.template')

@section('title', 'Kelas')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <div class="pagetitle col-6">
                    <h1>Daftar Kelas</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Kelas</li>
                        </ol>
                    </nav>

                </div>
                <div class="col-6 d-flex justify-content-end">
                    <div class="col-6">
                        <a href="/kelas/create" class="btn btn-success">Tambah Kelas <i class="bi bi-plus"></i></a>
                    </div>
                </div>
            </div>
        </div><!-- End Page Title -->
    </div>
    <div class="row">
        {{-- @php(dd($kelas)) --}}
        @foreach ($kelas as $value)
            <div class="col-3">
                <!-- Default Card -->
                <div class="card" onclick="detail({{ $value->idkelas }})" style="cursor: pointer">
                    <div class="card-body">
                        <h5 class="card-title">Kelas {{ $value->namaKelas }}</h5>
                        <p class="text-secondary">Wali Kelas : {{ $value->waliKelas }}</p>
                        <p class="text-secondary">Email : {{ $value->emailWaliKelas }}</p>
                    </div>
                </div><!-- End Default Card -->
            </div>
        @endForeach
    </div>

    <script>
        function detail(id) {
            window.location.href = `kelas/${id}`
        }
    </script>

@endsection
