@extends('layouts.template')

@section('title', 'Tambah Tagihan')

@section('main')
    <div class="pagetitle">
        <h1>Tambah Nama Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/tagihan">Tagihan</a></li>
                <li class="breadcrumb-item"><a href="/tagihan/create">Tambah Tagihan</a></li>
                <li class="breadcrumb-item"><a href="/namaTagihan">Nama Tagihan</a></li>
                <li class="breadcrumb-item active">Tambah Nama Tagihan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Input Nama Tagihan</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/namaTagihan" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="namaTagihan" class="form-label">Nama Tagihan</label>
                            <input type="text" class="form-control" id="namaTagihan" name="namaTagihan">
                            <div id="error-namaTagihan" class="text-danger"></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Multi Columns Form -->

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('input[name = "namaTagihan"]')
                .on('blur ', function() {
                    var fieldName = $(this).attr('name');
                    var fieldValue = $(this).val();

                    var data = {};
                    data[fieldName] = fieldValue;

                    $.ajax({
                        url: '/tagihanValidasi',
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
