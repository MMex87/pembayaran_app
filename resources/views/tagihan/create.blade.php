@extends('layouts.template')

@section('title', 'Tambah Tagihan')

@section('main')
    <div class="pagetitle">
        <h1>Tambah Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/tagihan">Tagihan</a></li>
                <li class="breadcrumb-item active">Tambah Tagihan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Input Tagihan</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/tagihan" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="namaTagihan" class="form-label">Nama Tagihan</label>
                            <select name="namaTagihan" id="namaTagihan" aria-describedby="tagihanHelp" class="form-control">
                                <option value="">-- Pilih Tagihan --</option>
                                @foreach ($namaTagihan as $item)
                                    <option value="{{ $item->idNamaTagihan }}">{{ $item->namaTagihan }}</option>
                                @endforeach
                            </select>
                            <div id="error-namaTagihan" class="text-danger"></div>
                            <div id="tagihanHelp" class="form-text">Jika Tagihan tidak ada, klik <a
                                    href="/namaTagihan">Tambah Tagihan</a></div>
                        </div>
                        <div class="col-md-12">
                            <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai"
                                value="{{ now()->format('Y-m-d') }}">
                            <div id="error-tanggalMulai" class="text-danger"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" value="{{ now()->format('Y-m-d') }}"
                                id="tanggalSelesai" name="tanggalSelesai">
                            <div id="error-tanggalSelesai" class="text-danger"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="hargaBayar" class="form-label">Harga Bayar</label>
                            <input type="number" class="form-control" id="hargaBayar" name="hargaBayar">
                            <div id="error-hargaBayar" class="text-danger"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="checkGolongan" value="true">
                                <label class="form-check-label" for="flexSwitchCheckReverse">Golongan</label>
                            </div>
                        </div>
                        <div class="col-md-12" id="displayGolongan" style="display: none">
                            <label for="golongan" class="form-label">Golongan</label>
                            <select name="golongan" id="golongan" class="form-control">
                                <option value="" selected>-- Pilih Golongan --</option>
                                @foreach ($golongan as $val)
                                    <option value="{{ $val->idGolongan }}">Golongan {{ $val->namaGolongan }}
                                    </option>
                                @endForeach
                            </select>
                            <div id="error-golongan" class="text-danger"></div>
                        </div>
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
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox" name="checkKelas[]"
                                                id="checkKelas1" value="1">
                                            <label class="form-check-label" for="checkKelas1">Kelas 1</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox" name="checkKelas[]"
                                                id="checkKelas2" value="2">
                                            <label class="form-check-label" for="checkKelas2">Kelas 2</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox"
                                                name="checkKelas[]" id="checkKelas3" value="3">
                                            <label class="form-check-label" for="checkKelas3">Kelas 3</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox"
                                                name="checkKelas[]" id="checkKelas4" value="4">
                                            <label class="form-check-label" for="checkKelas4">Kelas 4</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox"
                                                name="checkKelas[]" id="checkKelas5" value="5">
                                            <label class="form-check-label" for="checkKelas5">Kelas 5</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox"
                                                name="checkKelas[]" id="checkKelas6" value="6">
                                            <label class="form-check-label" for="checkKelas6">Kelas 6</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
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
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('allCheckKelas');
            const individualCheckboxes = document.querySelectorAll('.checkKelas');

            checkAll.addEventListener('change', function() {
                individualCheckboxes.forEach(function(checkbox) {
                    checkbox.disabled = checkAll.checked;
                    checkbox.checked = false;
                });
            });

            individualCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        checkAll.disabled = true;
                    } else {
                        checkAll.disabled = false;
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('input[name="checkGolongan"]').on('change', function() {
                let display = document.getElementById('displayGolongan')
                if (this.checked) {
                    display.style.display = ""
                } else {
                    display.style.display = "none"
                }
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            $('input[name = "hargaBayar"], input[name = "tanggalSelesai"], input[name = "tanggalMulai"]')
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

            // validasi checkbox
            $('input[name="checkKelas[]"]').on('change', function() {
                var hasChecked = $('input[name="checkKelas[]"]:checked').length > 0;
                $('#error-checkKelas').text(hasChecked ? '' : 'Pilih setidaknya satu kelas.');
                var hasErrors = $('div[id^="error-"]').filter(function() {
                    return $(this).text().length > 0;
                }).length > 0;
                $('#submitBtn').prop('disabled', hasErrors || !hasChecked);
            });

            // validasi all checkbox
            $('input[name="allCheckKelas"]').on('change', function() {
                var hasChecked = $('input[name="allCheckKelas"]:checked').length > 0;
                $('#error-checkKelas').text(hasChecked ? '' : 'Pilih setidaknya satu kelas.');
                var hasErrors = $('div[id^="error-"]').filter(function() {
                    return $(this).text().length > 0;
                }).length > 0;
                $('#submitBtn').prop('disabled', hasErrors || !hasChecked);
            });


            // Validasi Select
            $('select[name="namaTagihan"],select[name="status"]').on('change blur', function() {
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
