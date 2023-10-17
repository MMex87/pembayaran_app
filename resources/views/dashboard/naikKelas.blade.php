@extends('layouts.template')

@section('title', 'Naik Kelas')

@section('main')
    <div class="pagetitle">
        <h1>Naik Kelas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/kelas">Dashboard</a></li>
                <li class="breadcrumb-item active">Naik Kelas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($naikKelas == false)
                    <div class="card-body">
                        <h5 class="card-title">Form Generate Kelas Sebelumnya</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="/generateKelas" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label for="kelas" class="form-label">Kelas</label>
                                <br>
                                <table class="table-borderless container">
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="allCheckKelas"
                                                    id="allCheckKelas" value="Semua Kelas">
                                                <label class="form-check-label" for="allCheckKelas">Semua Kelas</label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div id="error-checkKelas" class="text-danger"></div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End Multi Columns Form -->
                    </div>
                @else
                    <div></div>
                @endif

                @if ($naikKelas == true)
                    <div class="card-body">
                        <h5 class="card-title">Form Generate Naik Kelas</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="/generateNaikKelas" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label for="kelas" class="form-label">Naik Kelas</label>
                                <br>
                                <table class="table-borderless container">
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="allCheckNaikKelas"
                                                    id="allCheckNaikKelas" value="Naik Kelas">
                                                <label class="form-check-label" for="allCheckNaikKelas">Naik Kelas</label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div id="error-checkKelas" class="text-danger"></div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End Multi Columns Form -->
                    </div>
                @else
                    <div></div>
                @endif
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
            // validasi all checkbox
            $('input[name="allCheckKelas"]').on('change', function() {
                var hasChecked = $('input[name="allCheckKelas"]:checked').length > 0;
                $('#error-checkKelas').text(hasChecked ? '' : 'Pilih Semua Kelas.');
                var hasErrors = $('div[id^="error-"]').filter(function() {
                    return $(this).text().length > 0;
                }).length > 0;
                $('#submitBtn').prop('disabled', hasErrors || !hasChecked);
            });
            $('input[name="allCheckNaikKelas"]').on('change', function() {
                var hasChecked = $('input[name="allCheckNaikKelas"]:checked').length > 0;
                $('#error-checkKelas').text(hasChecked ? '' : 'Pilih Naik Kelas.');
                var hasErrors = $('div[id^="error-"]').filter(function() {
                    return $(this).text().length > 0;
                }).length > 0;
                $('#submitBtn').prop('disabled', hasErrors || !hasChecked);
            });
        });
    </script>

@endsection
