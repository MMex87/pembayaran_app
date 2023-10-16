@extends('layouts.template')

@section('title', 'Tambah Siswa')

@section('main')
    <div class="pagetitle">
        <h1>Tambah Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/siswa">Siswa</a></li>
                <li class="breadcrumb-item active">Tambah Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambahkan Siswa Berdasarkan</h5>

                <!-- Default Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Tambahkan
                            Manual</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Import Excel</button>
                    </li>

                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Form Input Siswa</h5>

                                <!-- Multi Columns Form -->
                                <form class="row g-3" action="/siswa" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="namaSiswa" class="form-label">Nama Siswa</label>
                                        <input type="text" class="form-control" id="namaSiswa" name="namaSiswa" required>
                                        <div id="error-namaSiswa" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik" required>
                                        <div id="error-nik" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                            required>
                                        <div id="error-tanggalLahir" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="jenisKelamin" id="jenisKelamin" class="form-control" required>
                                            <option value="" selected>-- Pilih Jenis Kelamin --</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        <div id="error-jenisKelamin" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <select name="kelas" class="form-control" required>
                                            <option value="" selected>-- Pilih Kelas --</option>
                                            @foreach ($kelas as $value)
                                                <option value="{{ $value->idKelas }}">{{ $value->namaKelas }}
                                                </option>
                                            @endForeach
                                        </select>
                                        <div id="error-kelas" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" cols="15" rows="5" class="form-control" required></textarea>
                                        <div id="error-alamat" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="waliSiswa" class="form-label">Nama Wali</label>
                                        <input type="text" class="form-control" id="waliSiswa" name="waliSiswa" required>
                                        <div id="error-waliSiswa" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="noKIP" class="form-label">nomer KIP</label>
                                        <input type="text" class="form-control" id="noKIP" name="noKIP">
                                        <div id="error-noKIP" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="noWali" class="form-label">Nomer Wali Siswa</label>
                                        <input type="text" class="form-control" id="noWali" name="noWali">
                                        <div id="error-noWali" class="text-danger"></div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" id="submitBtn" class="btn btn-primary"
                                            disabled>Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form><!-- End Multi Columns Form -->

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Form Input Excel</h5>

                                <form action="/siswaImport" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="kelasExcel" class="form-label">Kelas</label>
                                        <select name="kelasExcel" class="form-control" required>
                                            <option value="" selected>-- Pilih Kelas --</option>
                                            @foreach ($kelas as $value)
                                                <option value="{{ $value->idKelas }}">{{ $value->namaKelas }}
                                                </option>
                                            @endForeach
                                        </select>
                                        <div id="error-kelasExcel" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="inputExcel" class="form-label">Upload File Excel</label>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" id="inputExcel" name="inputExcel"
                                                accept=".xlsx, .xls, .csv" required>
                                            <label class="input-group-text" for="inputExcel">Upload</label>
                                            <div id="error-inputExcel" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary" id="submitBtnExcel"
                                            disabled>Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- End Default Tabs -->

            </div>
        </div>
    </div>

    @if (Session::has('successExcel'))
        <script>
            $(document).ready(function() {
                swal.close();
                Swal.fire({
                    icon: 'success',
                    title: '{{ Session::get('successExcel') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
        </script>
        @php(session()->forget('successExcel'))
    @endif

    <script>
        $(document).ready(function() {
            $('input[name = "namaSiswa"], input[name = "nik"], input[name = "tanggalLahir"], textarea[name = "alamat"], input[name = "waliSiswa"], input[name= "inputExcel"]')
                .on('blur ', function() {
                    var fieldName = $(this).attr('name');
                    var fieldValue = $(this).val();

                    var data = {};
                    data[fieldName] = fieldValue;

                    $.ajax({
                        url: '/siswaValidasi',
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.errors && response.errors[fieldName]) {
                                $('#error-' + fieldName).text(response.errors[fieldName][0]);
                            } else {
                                $('#error-' + fieldName).text('');
                            }
                            // Cek apakah ada pesan kesalahan lain
                            var hasErrors = $('div[id^="error-"]').filter(function() {
                                return $(this).text().length > 0;
                            }).length > 0;

                            // Aktifkan atau non-aktifkan tombol submit berdasarkan apakah ada kesalahan
                            $('#submitBtn').prop('disabled', hasErrors);
                            $('#submitBtnExcel').prop('disabled', hasErrors);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error(xhr);
                        }
                    });
                });
        });
        // Validasi Select
        $('select[name="jenisKelamin"],select[name="kelas"],select[name="kelasExcel"]').on('change blur', function() {
            var fieldName = $(this).attr('name');
            var fieldValue = $(this).val();

            var data = {};
            data[fieldName] = fieldValue;

            $.ajax({
                url: '/siswaValidasi',
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.errors && response.errors[fieldName]) {
                        $('#error-' + fieldName).text(response.errors[fieldName][0]);
                    } else {
                        $('#error-' + fieldName).text('');
                    }

                    // Cek apakah ada pesan kesalahan lain
                    var hasErrors = $('div[id^="error-"]').filter(function() {
                        return $(this).text().length > 0;
                    }).length > 0;

                    // Aktifkan atau non-aktifkan tombol submit berdasarkan apakah ada kesalahan
                    $('#submitBtn').prop('disabled', hasErrors);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(xhr);
                }
            });
        });
    </script>

@endsection
