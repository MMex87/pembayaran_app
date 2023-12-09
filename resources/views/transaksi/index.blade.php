@extends('layouts.template')

@section('title', 'Pembayaran')

@section('styles')

    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 20px;
            cursor: pointer;
        }

        .ui-autocomplete .ui-menu-item {
            padding: 10px;
        }

        .ui-autocomplete .ui-menu-item:hover {
            background-color: #f5f5f5;
        }

        .ui-autocomplete .ui-state-active {
            background-color: #337ab7;
            color: #fff;
        }
    </style>

@endsection

@section('main')
    <div class="pagetitle">
        <h1>Pembayaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Pembayaran</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Bayar</h5>

                    <!-- Multi Columns Form -->
                    <form class="row g-3" action="/transaksi" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="invoice" class="form-label">Invoice</label>
                            <input type="text" class="form-control" id="invoice" name="invoice"
                                value="{{ $invoice }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $item)
                                    <option
                                        @if ($tagihan->isNotEmpty()) @selected($tagihan[0]->siswaPerKelas->siswa->idKelas == $item->idKelas) @else @if (request('kelas')) @selected(request('kelas') == $item->idKelas) @endIf
                                        @endif
                                        value="{{ $item->idKelas }}">{{ $item->namaKelas }}</option>
                                @endforeach
                            </select>
                            <div id="error-kelas" class="text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="siswa" class="form-label">Siswa</label>
                            <input type="text" class="form-control" id="siswa" name="siswa" required
                                @if ($tagihan->isNotEmpty()) value="{{ $tagihan[0]->siswaPerKelas->siswa->namaSiswa }}" @else value="{{ request('nama') ? request('nama') : '' }} " @endif>
                            <div id="error-siswa" class="text-danger"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="namaTagihan" class="form-label">Nama Tagihan</label>
                            <select name="namaTagihan" id="namaTagihan" class="form-control" required>
                                <option value="">-- Pilih Tagihan --</option>
                                @if ($tagihan->isNotEmpty())
                                    @foreach ($daftarTagihan as $val)
                                        <option value="{{ $val->idTagihan }}">
                                            {{ $val->tagihan->namaTagihan->namaTagihan }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div id="error-namaTagihan" class="text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="user" class="form-label">Admin User</label>
                            <select name="user" id="user" class="form-control" required>
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $item)
                                    <option @if ($tagihan->isNotEmpty()) @selected($tagihan[0]->transaksi->idUser == $item->idUser) @endif
                                        value="{{ $item->idUser }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <div id="error-user" class="text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="totalBayar" class="form-label">Nominal Yang Di Bayar</label>
                            <input type="text" class="form-control" id="totalBayar" name="totalBayar" disabled>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Tambah</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Multi Columns Form -->

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-beetwen">
                <div class="col-6">
                    <h5 class="card-title">Cart List Pembayaran</h5>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <h6 class="card-title">
                        <span>{{ $tagihan == '[]' ? '' : $tagihan[0]->siswaPerKelas->siswa->namaSiswa . ' (' . $invoice . ')' }}</span>
                    </h6>
                </div>
            </div>
            <!-- Table with stripped rows -->
            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                <div class="datatable-container">
                    <table class="table datatable datatable-table">
                        <thead>
                            <tr>
                                <th data-sortable="true" style="width: 5%;">#</th>
                                <th data-sortable="true" style="width: 35%;">Nama Tagihan</th>
                                <th data-sortable="true" style="width: 25%;">Nomor Tagihan</th>
                                <th data-sortable="true" style="width: 25%;">Harga Bayar</th>
                                <th data-sortable="true" style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($index = 1)
                            @foreach ($tagihan as $value)
                                <tr data-index="{{ $index }}">
                                    <td>{{ $index }}</td>
                                    <td>{{ $value->tagihan->namaTagihan->namaTagihan }}</td>
                                    <td>{{ $value->noTagihan }}</td>
                                    <td>{{ $value->tagihan->hargaBayar }}</td>
                                    <form action="/pembayaran/{{ $value->idTPS }}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <td><button type="submit" class="btn btn-danger">Hapus</button></td>
                                    </form>
                                </tr>
                                @php($index++)
                            @endForeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success me-5" data-bs-toggle="modal"
                data-bs-target="#modalCheckOut">Bayar</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCheckOut" tabindex="-1" aria-labelledby="modalCheckOutLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCheckOutLabel">Chekout Pembayaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        <div class="datatable-container">
                            <table class="table datatable datatable-table">
                                <thead>
                                    <tr>
                                        <th data-sortable="true" style="width: 5%;">#</th>
                                        <th data-sortable="true" style="width: 35%;">Nama Tagihan</th>
                                        <th data-sortable="true" style="width: 30%;">Nomor Tagihan</th>
                                        <th data-sortable="true" style="width: 30%;">Harga Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($total = 0)
                                    @forelse ($tagihan as $value)
                                        <tr data-index="{{ $loop->index + 1 }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $value->tagihan->namaTagihan->namaTagihan }}</td>
                                            <td>{{ $value->noTagihan }}</td>
                                            <td>{{ $value->tagihan->hargaBayar }}</td>
                                        </tr>
                                        @php($total += $value->tagihan->hargaBayar)
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="3" class="text-end">Total: </td>
                                        <td colspan="2">Rp {{ $total }}</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="/print-nota" type="button" id="btnPrint" class="btn btn-primary">Print</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        var idKelas

        function getId() {
            var kelas = document.getElementById('kelas');
            var id = kelas.value;

            idKelas = id;
        }

        // Tambahkan event listener untuk memanggil fungsi ketika perubahan terjadi
        document.getElementById("kelas").addEventListener("change", getId);

        $(document).ready(function() {
            // Mengekstrak nilai parameter 'kelas' dari URL
            var urlParams = new URLSearchParams(window.location.search);

            var selectedSiswa = ""; // Variabel untuk menyimpan siswa yang dipilih
            var selectedIdSiswa = "";


            idKelas = urlParams.get('kelas');
            selectedIdSiswa = urlParams.get('siswa')
            $("#siswa").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: '/getSiswa',
                        data: {
                            idKelas: idKelas,
                            namaSiswa: request.term,
                        },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        },
                    });
                },
                messages: {
                    noResults: '',
                    results: function() {}
                },
                minLength: 1,
                create: function() {
                    $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                        var listItem = $("<li class='list-group-item list-group-item-action'>")
                            .append("<div>" + item.namaSiswa + "</div>")
                            .appendTo(ul);

                        // Tambahkan event click pada setiap elemen <li>
                        listItem.click(function() {
                            selectedSiswa = item
                                .namaSiswa; // Simpan nama siswa yang dipilih
                            selectedIdSiswa = item
                                .idSiswa;
                            $("#siswa").val(
                                selectedSiswa); // Isi input dengan nama siswa yang dipilih
                            $("#autocomplete-results").empty(); // Hapus daftar hasil
                        });
                        return listItem;
                    }
                }
            });

            // Event blur pada input #siswa
            $("#siswa").blur(function() {
                // Jika input dikosongkan, kembalikan nilai yang dipilih sebelumnya
                if ($(this).val().trim() === "") {
                    $(this).val(selectedSiswa);
                }
            });

            // Tambahkan event listener untuk memanggil fungsi ketika perubahan pada input siswa
            $("#namaTagihan").on("focus", function() {
                // var selectedIdSiswa = $(this).val(); // Ambil nilai dari input siswa

                // Lakukan permintaan Ajax untuk mengambil data tagihan
                $.ajax({
                    url: '/getTagihan',
                    data: {
                        idSiswa: selectedIdSiswa,
                        idKelas: idKelas
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Fungsi untuk mengisi elemen select namaTagihan
                        function populateSelect(data) {
                            var select = $(
                                "#namaTagihan"); // Ganti dengan ID elemen select Anda
                            select.empty(); // Kosongkan elemen select
                            // Tambahkan opsi ke elemen select
                            $.each(data, function(index, item) {
                                // Cek apakah ada data dalam array nama_tagihan
                                if (item.nama_tagihan) {
                                    // Ambil nilai namaTagihan dari data pertama dalam array nama_tagihan
                                    var namaTagihan = item.nama_tagihan.namaTagihan;
                                    select.append(new Option(namaTagihan, item
                                        .idTagihan));
                                }
                            });
                        }

                        // Panggil fungsi untuk mengisi elemen select
                        populateSelect(data);
                    }
                });
            });
            $('#namaTagihan').on('click', function() {
                var selectTagihan = $(this).val()
                // console.log(selectTagihan);

                $.ajax({
                    url: '/getTotalTagihan',
                    data: {
                        idTagihan: selectTagihan
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#totalBayar').val(data.hargaBayar);
                    }
                })
            })
        });
    </script>

    @if (Session::has('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ Session::get('success') }}',
                    icon: 'success'
                });
            });
        </script>
    @endif

    @if (Session::has('successBayar'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ Session::get('successBayar') }}',
                    icon: 'success'
                });
            });
        </script>
    @endif

    @if (Session::has('gagal-email'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Email Gagal Terkirim!',
                    text: '{{ Session::get('gagal-email') }}',
                    icon: 'error'
                });
            });
        </script>
    @endif

    @if (Session::has('print'))
        <script>
            $(document).ready(function() {

                const pdfURL = '{{ Session::get('print') }}'; // Gantilah dengan URL atau path menuju PDF Anda

                // Buka jendela baru dengan URL PDF
                const newWindow = window.open(pdfURL, '_blank');

                // Tunggu hingga jendela baru selesai memuat PDF
                newWindow.onload = () => {
                    // Jalankan perintah mencetak setelah jendela selesai memuat
                    newWindow.print();
                };
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('input[name = "siswa"]')
                .on('blur ', function() {
                    var fieldName = $(this).attr('name');
                    var fieldValue = $(this).val();

                    var data = {};
                    data[fieldName] = fieldValue;

                    $.ajax({
                        url: '/transaksiValidasi',
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

            // Validasi Select
            $('select[name="namaTagihan"],select[name="kelas"]').on('change blur', function() {
                var fieldName = $(this).attr('name');
                var fieldValue = $(this).val();

                var data = {};
                data[fieldName] = fieldValue;

                $.ajax({
                    url: '/transaksiValidasi',
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
