@extends('layouts.template')

@section('title', 'Tagihan')

@section('main')

    <div class="pagetitle">
        <h1>Daftar Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Tagihan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Tagihan</h5>
                        <!-- Table with stripped rows -->
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <a href="/tagihan/create" class="btn btn-success">Tambah Tagihan <i
                                        class="bi bi-plus-lg"></i></a>
                                <div class="datatable-search">
                                    <form action="/tagihan" method="GET">
                                        @csrf
                                        <input class="datatable-input" placeholder="Search [Nama Tagihan]" type="search"
                                            title="Search within table" value="{{ request('searchTagihan') }}"
                                            name="searchTagihan">
                                    </form>
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 5%;">#</th>
                                            <th data-sortable="true" style="width: 20%;">Nama Tagihan</th>
                                            <th data-sortable="true" style="width: 15%;">Tanggal Mulai</th>
                                            <th data-sortable="true" style="width: 15%;">Tagihan Selesai</th>
                                            <th data-sortable="true" style="width: 15%;">Kelas</th>
                                            <th data-sortable="true" style="width: 15%;">Status</th>
                                            <th data-sortable="true" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($index = 1)
                                        @foreach ($tagihan as $value)
                                            <tr data-index="{{ $index }}">
                                                <td>{{ $index }}</td>
                                                <td>{{ $value->namaTagihan->namaTagihan }}</td>
                                                <td>{{ $value->tanggalMulai }}</td>
                                                <td>{{ $value->tanggalSelesai }}</td>
                                                <td>{{ $value->kelas }}</td>
                                                <td>{{ $value->status }}</td>
                                                <td><a href="/tagihan/{{ $value->idTagihan }}/edit"
                                                        class="btn btn-warning">Edit</a></td>
                                            </tr>
                                            @php($index++)
                                        @endForeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                {{ $tagihan->appends(['searchTagihan' => request('searchTagihan')])->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
