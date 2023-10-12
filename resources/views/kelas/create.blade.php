@extends('layouts.template')

@section('title', 'Tambah Kelas')

@section('main')
    <div class="pagetitle">
        <h1>Tambah Kelas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/kelas">Kelas</a></li>
                <li class="breadcrumb-item active">Tambah Kelas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Input Kelas</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/kelas" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="namaKelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="namaKelas" name="namaKelas" required>
                            <div id="error-namaKelas" class="text-danger"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="waliKelas" class="form-label">Wali Kelas</label>
                            <input type="text" class="form-control" id="waliKelas" name="waliKelas" required>
                            <div id="error-waliKelas" class="text-danger"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="emailWaliKelas" class="form-label">Email Wali Kelas</label>
                            <input type="email" class="form-control" id="emailWaliKelas" name="emailWaliKelas" required>
                            <div class="text-danger" id="error-emailWaliKelas"></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Multi Columns Form -->

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('input[name="namaKelas"], input[name="waliKelas"], input[name="emailWaliKelas"]').on('blur',
                function() {
                    var fieldName = $(this).attr('name');
                    var fieldValue = $(this).val();

                    var data = {};
                    data[fieldName] = fieldValue;

                    $.ajax({
                        url: '/kelasValidasi',
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
        });
    </script>

@endsection
