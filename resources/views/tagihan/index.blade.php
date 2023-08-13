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
                                    <input class="datatable-input" placeholder="Search..." type="search"
                                        title="Search within table">
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 5%;">#</th>
                                            <th data-sortable="true" style="width: 25%;">Nama Tagihan</th>
                                            <th data-sortable="true" style="width: 20%;">Tanggal Mulai</th>
                                            <th data-sortable="true" style="width: 20%;">Tagihan Selesai</th>
                                            <th data-sortable="true" style="width: 15%;">Status</th>
                                            <th data-sortable="true" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($index = 1)
                                        @foreach ($tagihan as $value)
                                            <tr data-index="{{ $index }}">
                                                <td>{{ $index }}</td>
                                                <td>{{ $value->namaTagihan->first()->namaTagihan }}</td>
                                                <td>{{ $value->tanggalMulai }}</td>
                                                <td>{{ $value->tanggalSelesai }}</td>
                                                <td>{{ $value->status }}</td>
                                                <td><a href="/tagihan" class="btn btn-primary">Detail</a></td>
                                            </tr>
                                            @php($index++)
                                        @endForeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                {{ $tagihan->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection