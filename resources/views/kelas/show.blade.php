@extends('layouts.template')

@section('title', 'Kelas ' . $kelas->namaKelas)

@section('main')
    <div class="pagetitle">
        <h1>Detail Kelas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/kelas">Kelas</a></li>
                <li class="breadcrumb-item active">Kelas {{ $kelas->namaKelas }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Siswa</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Wali Kelas</div>
                                    <div class="col-lg-9 col-md-8">{{ $kelas->waliKelas }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Email Wali Kelas</div>
                                    <div class="col-lg-9 col-md-8">{{ $kelas->emailWaliKelas }}</div>
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="/kelas/{{ $kelas->idKelas }}/edit" class="btn btn-warning"><i
                                        class="bi bi-pencil-square"></i></a>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <a href="/siswa/create" class="btn btn-success">Tambah Siswa <i
                                        class="bi bi-plus-lg"></i></a>
                                <div class="datatable-search">
                                    <form action="/kelas/{{ $idKelas }}/search" method="GET" id="searchForm">
                                        @csrf
                                        <input class="datatable-input" placeholder="Search [Nama, NIK]" type="search"
                                            title="Search within table" name="searchKelas"
                                            value="{{ request('searchKelas') }}">
                                    </form>
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 5%;">#</th>
                                            <th data-sortable="true" style="width: 20%;">Nama</th>
                                            <th data-sortable="true" style="width: 20%;">NIK</th>
                                            <th data-sortable="true" style="width: 10%;">Jenis Kelamin</th>
                                            <th data-sortable="true" style="width: 15%;">Kelas</th>
                                            <th data-sortable="true" style="width: 20%;">Nama Wali</th>
                                            <th data-sortable="true" style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($siswa->isEmpty())
                                            <tr>
                                                <td colspan="7">
                                                    Tidak ada hasil yang ditemukan.
                                                </td>
                                            </tr>
                                        @else
                                            @php($index = 1)
                                            @foreach ($siswa as $value)
                                                <tr data-index="{{ $index }}">
                                                    <td>{{ $index }}</td>
                                                    <td>{{ $value->namaSiswa }}</td>
                                                    <td>{{ $value->nik }}</td>
                                                    <td>{{ $value->jenisKelamin }}</td>
                                                    <td>{{ $value->kelas->first()->namaKelas }}</td>
                                                    <td>{{ $value->namaWali }}</td>
                                                    <td><a href="/siswa/{{ $value->idSiswa }}"
                                                            class="btn btn-primary">Detail</a></td>
                                                </tr>
                                                @php($index++)
                                            @endForeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                {{ $siswa->appends(['searchKelas' => request('searchKelas')])->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
