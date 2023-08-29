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
                            <label for="faktur" class="form-label">Faktur</label>
                            <input type="text" class="form-control" id="faktur" name="faktur"
                                value="{{ $faktur }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->idkelas }}">{{ $item->namaKelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="siswa" class="form-label">Siswa</label>
                            <input type="text" class="form-control" id="siswa" name="siswa">
                        </div>
                        <div class="col-md-12">
                            <label for="namaTagihan" class="form-label">Nama Tagihan</label>
                            <select name="namaTagihan" id="namaTagihan" class="form-control">
                                <option value="">-- Pilih Tagihan --</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="totalBayar" class="form-label">Nominal Yang Di Bayar</label>
                            <input type="text" class="form-control" id="totalBayar" name="totalBayar" disabled>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Bayar</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Multi Columns Form -->

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
            var selectedSiswa = ""; // Variabel untuk menyimpan siswa yang dipilih
            var selectedIdSiswa = "";

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
                                if (item.nama_tagihan && item.nama_tagihan.length > 0) {
                                    // Ambil nilai namaTagihan dari data pertama dalam array nama_tagihan
                                    var namaTagihan = item.nama_tagihan[0].namaTagihan;
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


@endsection
