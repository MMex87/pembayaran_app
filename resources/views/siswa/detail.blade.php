@extends('layouts.template')

@section('title', 'Detail Siswa')

@section('main')
    <div class="pagetitle">
        <h1>Detail Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/siswa">Siswa</a></li>
                <li class="breadcrumb-item active">Detail Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Detail</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Data</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-settings">Tagihan</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Pindah Kelas</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <h5 class="card-title">Detail Siswa</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Nama</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->namaSiswa }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">NIK</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->nik }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
                                    <div class="col-lg-9 col-md-8"> {{ $siswa->tanggalLahir }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->jenisKelamin }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Kelas</div>
                                    <div class="col-lg-9 col-md-8">{{ $namaKelas }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->alamat }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">No HP Wali</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->noHP }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nama Wali</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->namaWali }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nomor KIP</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->noKIP }}</div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="row-2">
                                        <form action="/siswa/{{ $siswa->idSiswa }}" method="POST"
                                            id="formDelete{{ $siswa->idSiswa }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-danger"
                                                onclick="btnHapus('{{ $siswa->idSiswa }}','{{ $siswa->namaSiswa }}')">Hapus
                                                Siswa <i class="bi bi-trash-fill"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form method="POST" action="/siswa/{{ $siswa->idSiswa }}">
                                    @method('PATCH')
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="namaSiswa" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="namaSiswa" type="text" class="form-control" id="namaSiswa"
                                                value="{{ $siswa->namaSiswa }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="nik" class="col-md-4 col-lg-3 col-form-label">NIK</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="nik" type="text" class="form-control" id="nik"
                                                value="{{ $siswa->nik }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="tanggalLahir" class="col-md-4 col-lg-3 col-form-label">Tanggal
                                            Lahir</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="tanggalLahir" type="date" class="form-control" id="tanggalLahir"
                                                value="{{ $siswa->tanggalLahir }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="jenisKelamin" class="col-md-4 col-lg-3 col-form-label">Jenis
                                            Kelamin</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="jenisKelamin" type="text" class="form-control"
                                                id="jenisKelamin" value="{{ $siswa->jenisKelamin }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="alamat" class="form-control" id="alamat" style="height: 100px">{{ $siswa->alamat }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="noWali" class="col-md-4 col-lg-3 col-form-label">No HP Wali</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="noWali" type="text" class="form-control" id="noWali"
                                                value="{{ $siswa->noHP }}">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="waliSiswa" class="col-md-4 col-lg-3 col-form-label">Nama Wali</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="waliSiswa" type="text" class="form-control" id="waliSiswa"
                                                value="{{ $siswa->namaWali }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="noKIP" class="col-md-4 col-lg-3 col-form-label">Nomer KIP</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="noKIP" type="text" class="form-control" id="noKIP"
                                                value="{{ $siswa->noKIP }}">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings">

                                <!-- Table with stripped rows -->
                                <div
                                    class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                    <div class="datatable-container">
                                        <table class="table datatable datatable-table">
                                            <thead>
                                                <tr>
                                                    <th data-sortable="true" style="width: 5%;">#</th>
                                                    <th data-sortable="true" style="width: 25%;">Nama Tagihan</th>
                                                    <th data-sortable="true" style="width: 20%;">Nomor Tagihan</th>
                                                    <th data-sortable="true" style="width: 20%;">Status</th>
                                                    <th data-sortable="true" style="width: 20%;">Harga Bayar</th>
                                                    <th data-sortable="true" style="width: 10%;">Aksi</th>
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
                                                        <td>{{ $value->tagihan->namaTagihan->namaTagihan }}</td>
                                                        <td>{{ $value->noTagihan }}</td>
                                                        <td>{{ $value->status }}</td>
                                                        <td>{{ $value->tagihan->hargaBayar }}</td>
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
                                </div>
                                <!-- End Table with stripped rows -->

                                <div class="datatable-bottom">
                                    {{ $tagihan->links('vendor.pagination.bootstrap-5') }}
                                </div>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Pindah Kelas Form -->
                                <form action="/siswa/{{ $siswa->idSiswa }}/{{ $siswa->siswaPerKelas[0]->idSPK }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="row mb-3">
                                        <label for="namaSiswa" class="col-md-4 col-lg-3 col-form-label">Nama Siswa</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="nama" type="text" class="form-control"
                                                value="{{ $siswa->namaSiswa }}" id="namaSiswa" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="namaKelas" class="col-md-4 col-lg-3 col-form-label">Kelas
                                            Lama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="namaKelas" type="text" class="form-control"
                                                value="{{ $kelas->namaKelas }}" id="namaKelas" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="kelas" class="col-md-4 col-lg-3 col-form-label">Kelas</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select name="kelas" id="kelas" class="form-control">
                                                @foreach ($data_kelas as $value)
                                                    <option value="{{ $value->idKelas }}"
                                                        {{ $value->namaKelas == $namaKelas ? 'selected' : '' }}>
                                                        {{ $value->namaKelas }}</option>
                                                @endForeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Pindah Kelas</button>
                                    </div>
                                </form><!-- End Pindah Kelas Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        const btnHapus = (id, nama) => {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: `Kamu ingin menghapus data yang bernama ${nama}!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formDelete' + id).submit()
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }
    </script>
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
