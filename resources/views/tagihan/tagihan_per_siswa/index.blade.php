@extends('layouts.template')

@section('title', 'Tagihan Per Siswa')

@section('main')

    <div class="pagetitle">
        <h1>Daftar Tagihan Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Tagihan Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Tagihan Siswa</h5>
                        <!-- Table with stripped rows -->
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <a href="/tagihan/create" class="btn btn-success">Tambah Tagihan <i
                                        class="bi bi-plus-lg"></i></a>
                                <div class="datatable-search">
                                    <form action="/tagihanPerSiswa" method="get">
                                        <input class="datatable-input" placeholder="Tagihan, Siswa, Status" type="search"
                                            title="Search within table" value="{{ request('search') }}" name="search">
                                    </form>
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 5%;">#</th>
                                            <th data-sortable="true" style="width: 25%;">Nama Siswa</th>
                                            <th data-sortable="true" style="width: 25%;">Nama Tagihan</th>
                                            <th data-sortable="true" style="width: 15%;">Kelas</th>
                                            <th data-sortable="true" style="width: 15%;">Status Tagihan</th>
                                            <th data-sortable="true" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($index = 1)
                                        @foreach ($tagihan as $value)
                                            @php($tahunAjar = $value->siswaPerKelas->tahunAjar->tahun)
                                            @php($temp = explode('/', $tahunAjar))
                                            @php($tahun = implode('-', $temp))
                                            @php($dataNama = $value->siswaPerKelas->siswa->namaSiswa)
                                            @php($tempNama = explode(' ', $dataNama))
                                            @php($nama = implode('', $tempNama))
                                            @php($namaKelas = $value->siswaPerKelas->kelas->namaKelas)
                                            <tr data-index="{{ $index }}">
                                                <td>{{ $index }}</td>
                                                <td>{{ $value->siswaPerKelas->siswa->namaSiswa }}</td>
                                                <td>{{ $value->tagihan->namaTagihan->namaTagihan }}</td>
                                                <td>{{ $value->siswaPerKelas->kelas->namaKelas }}</td>
                                                <td>{{ $value->status }}</td>
                                                @if ($value->status == 'Lunas')
                                                    <td><button class="btn btn-success" id="printPDF"
                                                            value="/pdf/{{ $tahun }}/{{ $namaKelas }}/{{ $nama }}.pdf">Print</button>
                                                    </td>
                                                @else
                                                    <td><a class="btn btn-primary" href="/pembayaran">Bayar</a>
                                                    </td>
                                                @endif
                                            </tr>
                                            @php($index++)
                                        @endForeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                {{ $tagihan->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>


    <script>
        $(document).ready(function() {
            $("#printPDF").click(function() {
                const pdfURL = $(this).val();
                console.log(pdfURL)
                // Buka jendela baru dengan URL PDF
                const newWindow = window.open(pdfURL, '_blank');

                // Tunggu hingga jendela baru selesai memuat PDF
                newWindow.onload = () => {
                    // Jalankan perintah mencetak setelah jendela selesai memuat
                    newWindow.print();
                };
            })
        })
    </script>

@endsection
