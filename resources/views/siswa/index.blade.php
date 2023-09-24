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
                                    <form action="/siswa" method="GET">
                                        @csrf
                                        <input class="datatable-input" placeholder="Search [Nama, NIK]" type="search"
                                            title="Search within table" name="searchSiswa"
                                            value="{{ request('searchSiswa') }}">
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
                                                    <td>{{ $value->siswa->namaSiswa }}</td>
                                                    <td>{{ $value->siswa->nik }}</td>
                                                    <td>{{ $value->siswa->jenisKelamin }}</td>
                                                    <td>{{ $value->kelas->namaKelas }}</td>
                                                    <td>{{ $value->siswa->namaWali }}</td>
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
                                {{ $siswa->appends(['searchSiswa' => request('searchSiswa')])->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
