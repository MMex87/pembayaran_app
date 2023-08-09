@extends('layouts.template')

@section('title', 'Siswa')

@section('main')
    <div class="pagetitle">
        <h1>Daftar Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Semua Siswa</h5>
                        <!-- Table with stripped rows -->
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <a href="/siswa/create" class="btn btn-success">Tambah Siswa <i
                                        class="bi bi-plus-lg"></i></a>
                                <div class="datatable-search">
                                    <input class="datatable-input" placeholder="Search..." type="search"
                                        title="Search within table">
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
                                            <th data-sortable="true" style="width: 15%;">Tanggal Lahir</th>
                                            <th data-sortable="true" style="width: 20%;">Nama Wali</th>
                                            <th data-sortable="true" style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($index = 1)
                                        @foreach ($siswa as $value)
                                            <tr data-index="{{ $index }}">
                                                <td>{{ $index }}</td>
                                                <td>{{ $value->namaSiswa }}</td>
                                                <td>{{ $value->nik }}</td>
                                                <td>{{ $value->jenisKelamin }}</td>
                                                <td>{{ $value->tanggalLahir }}</td>
                                                <td>{{ $value->namaWali }}</td>
                                                <td><a href="/siswa/{{ $value->idSiswa }}"
                                                        class="btn btn-primary">Detail</a></td>
                                            </tr>
                                            @php($index++)
                                        @endForeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                {{ $siswa->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
