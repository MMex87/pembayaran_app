@extends('layouts.template')

@section('title', 'Dashboard')

@section('main')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Siswa</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $siswa }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Tagihan</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-card-list"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tagihan }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Tagihan Siswa Belum Lunas</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journals"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tps }}</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title">Tahun Ajar</h5>
                                <div
                                    class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                    <div class="datatable-top">
                                        @if ($handleTambah == true)
                                            <form action="/tahunAjar" method="POST">
                                                @csrf
                                                {{-- <input type="hidden" name="tahun" value="K5VDWiL9VYTM9z2urtCOUXP3r4k9E6jBr2IXKiuX"> --}}
                                                <button type="submit"class="btn btn-success">Tambah Tahun Ajar <i
                                                        class="bi bi-plus-lg"></i></button>
                                            </form>
                                        @endif
                                        <div class="datatable-search">
                                            <form action="/" method="GET">
                                                @csrf
                                                <input class="datatable-input" placeholder="Search [Tahun]" type="search"
                                                    title="Search within table" value="{{ request('searchTahun') }}"
                                                    name="searchTahun">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="datatable-container">
                                        <table class="table table-borderless datatable datatable-table">
                                            <thead>
                                                <tr>
                                                    <th data-sortable="true" style="width: 10%;">#</th>
                                                    <th data-sortable="true" style="width: 35%;">Tahun</th>
                                                    <th data-sortable="true" style="width: 30%;">Status</th>
                                                    <th data-sortable="true" style="width: 25%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php($index = 1)
                                                @foreach ($tahunAjar as $val)
                                                    <tr data-index="{{ $index }}">
                                                        <td>{{ $index }}</td>
                                                        <td>{{ $val->tahun }}</td>
                                                        <td>{{ $val->aktif == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                                        @if ($val->aktif == 1)
                                                            @if ($handleNaikKelas == true)
                                                                <td>
                                                                    <a class="btn btn-primary" href="/naikKelas">Naik
                                                                        Kelas</a>
                                                                </td>
                                                            @else
                                                                <td>Aktif</td>
                                                            @endif
                                                        @else
                                                            <td>
                                                                <form action="/tahunAjar/{{ $val->idTahunAjar }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="aktif"
                                                                        value="{{ true }}">
                                                                    <button class="btn btn-success">Aktifkan</button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    @php($index++)
                                                @endForeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="datatable-bottom">
                                        {{ $tahunAjar->appends(['searchTahun' => request('searchTahun')])->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Recent Activity Pembayaran</h5>

                        <div class="activity">
                            @foreach ($transaksi as $val)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $val->waktu_hitung }}</div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">
                                        {{ $val->tagihanPerSiswa->tagihan->namaTagihan->namaTagihan }} -
                                        {{ $val->tagihanPerSiswa->siswaPerKelas->siswa->namaSiswa }}
                                    </div>
                                </div><!-- End activity item-->
                            @endForeach
                        </div>

                    </div>
                </div><!-- End Recent Activity -->

            </div><!-- End Right side columns -->

        </div>
    </section>
@endsection
