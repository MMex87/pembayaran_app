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
                            <div id="tagihanHelp" class="form-text">Jika Tagihan tidak ada, klik <a
                                    href="/namaTagihan">Tambah Tagihan</a></div>
                        </div>
                        <div class="col-md-12">
                            <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai"
                                value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-12">
                            <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai">
                        </div>
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status Aktif</label>
                            <select name="status" id="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        {{-- <div class="col-md-12">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                <option value="semua kelas">semua kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->idKelas }}">{{ $item->namaKelas }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-12">
                            <label for="kelas" class="form-label">Kelas</label>
                            <br>
                            <table class="table-borderless container">
                                <tr>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="allCheckKelas"
                                                id="allCheckKelas" value="semua kelas">
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
                                            <input class="form-check-input checkKelas" type="checkbox" name="checkKelas[]"
                                                id="checkKelas3" value="3">
                                            <label class="form-check-label" for="checkKelas3">Kelas 3</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox" name="checkKelas[]"
                                                id="checkKelas4" value="4">
                                            <label class="form-check-label" for="checkKelas4">Kelas 4</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkKelas" type="checkbox" name="checkKelas[]"
                                                id="checkKelas5" value="5">
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
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
@endsection
