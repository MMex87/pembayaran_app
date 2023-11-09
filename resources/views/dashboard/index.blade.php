@extends('layouts.template')

@section('title', 'Dashboard')

@section('main')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Siswa</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $siswa }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Tagihan</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-card-list"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tagihan }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Tagihan Siswa Belum Lunas</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journals"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tps }}</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title">User</h5>
                                <div
                                    class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                    <div class="datatable-top">
                                        <div>
                                            <button type="submit"class="btn btn-success" id="btnTambahUser">Tambah User<i
                                                    class="bi bi-plus-lg"></i></button>
                                            <button type="submit"class="btn btn-warning" id="btnBatalUser"
                                                style="display: none">Batal</button>
                                        </div>
                                        <div class="datatable-search">
                                            <form action="/" method="GET">
                                                @csrf
                                                <input class="datatable-input" placeholder="Search [Tahun]" type="search"
                                                    title="Search within table" value="{{ request('searchTahun') }}"
                                                    name="searchTahun">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row" id="form-tambah-user" style="display: none">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="namaUser" class="form-label">Nama User</label>
                                                        <input type="text" class="form-control" id="namaUser"
                                                            name="namaUser">
                                                        <div id="error-namaUser" class="text-danger"></div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="jabatan" class="form-label">Jabatan</label>
                                                        <input type="text" class="form-control" id="jabatan"
                                                            name="jabatan">
                                                        <div id="error-jabatan" class="text-danger"></div>
                                                    </div>
                                                    <button class="btn btn-primary" id="btn-save">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="datatable-container">
                                        <table class="table table-borderless datatable datatable-table">
                                            <thead>
                                                <tr>
                                                    <th data-sortable="true" style="width: 5%;">#</th>
                                                    <th data-sortable="true" style="width: 35%;">Nama</th>
                                                    <th data-sortable="true" style="width: 25%;">Jabatan</th>
                                                    <th data-sortable="true" style="width: 35%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($index = 1)
                                                @foreach ($users as $val)
                                                    <tr data-index="{{ $index }}" id="col-data-{{ $val->idUser }}">
                                                        <td>{{ $index }}</td>
                                                        <td class="displayFormEditNormal">{{ $val->nama }}</td>
                                                        <td class="displayFormEditNormal">{{ $val->jabatan }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-beetwen">
                                                                <a class="btn btn-warning me-3"
                                                                    onclick="btnEdit('{{ $val->nama }}','{{ $val->jabatan }}','{{ $val->idUser }}')"
                                                                    id="btn-edit">Edit</a>
                                                                <form action="user/{{ $val->idUser }}" method="POST"
                                                                    id="deleteForm{{ $val->idUser }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-danger"
                                                                        onclick="confirmDelete('{{ $val->idUser }}','{{ $val->nama }}')">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr data-index="{{ $index }}"
                                                        id="col-update-{{ $val->idUser }}" style="display: none">
                                                        <form action="/user/{{ $val->idUser }}" method="POST">
                                                            @method('PATCH')
                                                            @csrf
                                                            <td>{{ $index }}</td>
                                                            <td><input type="text" class="form-control"
                                                                    id="namaUser-{{ $val->idUser }}" name="namaUser">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    id="jabatan-{{ $val->idUser }}" name="jabatan"></td>
                                                            <td>
                                                                <div class="d-flex justify-content-beetwen">
                                                                    <button type="submit"
                                                                        class="btn btn-primary me-3">Save</button>
                                                                    <a onclick="btnBack('{{ $val->idUser }}')"
                                                                        class="btn btn-warning">back</a>
                                                                </div>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                    @php($index++)
                                                @endForeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="datatable-bottom">
                                        {{ $tahunAjar->appends(['searchTahun' => request('searchTahun')])->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">

                                <div class="card-body">
                                    <h5 class="card-title">Tahun Ajar</h5>
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-top">
                                            @if ($handleTambah == true)
                                                <form action="/tahunAjar" method="POST">
                                                    @csrf
                                                    {{-- <input type="hidden" name="tahun" value="K5VDWiL9VYTM9z2urtCOUXP3r4k9E6jBr2IXKiuX"> --}}
                                                    <button type="submit"class="btn btn-success">Tambah Tahun Ajar <i
                                                            class="bi bi-plus-lg"></i></button>
                                                </form>
                                            @endif
                                            <div class="datatable-search">
                                                <form action="/" method="GET">
                                                    @csrf
                                                    <input class="datatable-input" placeholder="Search [Tahun]"
                                                        type="search" title="Search within table"
                                                        value="{{ request('searchTahun') }}" name="searchTahun">
                                                </form>
                                            </div>
                                        </div>
                                        <div class="datatable-container">
                                            <table class="table table-borderless datatable datatable-table">
                                                <thead>
                                                    <tr>
                                                        <th data-sortable="true" style="width: 10%;">#</th>
                                                        <th data-sortable="true" style="width: 35%;">Tahun</th>
                                                        <th data-sortable="true" style="width: 30%;">Status</th>
                                                        <th data-sortable="true" style="width: 25%;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php($index = 1)
                                                    @foreach ($tahunAjar as $val)
                                                        <tr data-index="{{ $index }}">
                                                            <td>{{ $index }}</td>
                                                            <td>{{ $val->tahun }}</td>
                                                            <td>{{ $val->aktif == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                                            @if ($val->aktif == 1)
                                                                @if ($handleNaikKelas == true)
                                                                    <td>
                                                                        <a class="btn btn-primary" href="/naikKelas">Naik
                                                                            Kelas</a>
                                                                    </td>
                                                                @else
                                                                    <td>Aktif</td>
                                                                @endif
                                                            @else
                                                                <td>
                                                                    <form action="/tahunAjar/{{ $val->idTahunAjar }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="aktif"
                                                                            value="{{ true }}">
                                                                        <button class="btn btn-success">Aktifkan</button>
                                                                    </form>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @php($index++)
                                                    @endForeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="datatable-bottom">
                                            {{ $tahunAjar->appends(['searchTahun' => request('searchTahun')])->links('vendor.pagination.bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div><!-- End Left side columns -->
            </div>

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Recent Activity Pembayaran</h5>

                        <div class="activity">
                            @foreach ($transaksi as $val)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $val->waktu_hitung }}</div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">
                                        {{ $val->tagihanPerSiswa->tagihan->namaTagihan->namaTagihan }} -
                                        {{ $val->tagihanPerSiswa->siswaPerKelas->siswa->namaSiswa }}
                                    </div>
                                </div><!-- End activity item-->
                            @endForeach
                        </div>

                    </div>
                </div><!-- End Recent Activity -->

            </div><!-- End Right side columns -->
    </section>

    <script>
        $(document).ready(function() {
            // tambah User
            let tambah = document.getElementById("btnTambahUser")
            let batal = document.getElementById("btnBatalUser")
            let form = document.getElementById('form-tambah-user')

            $("#btnTambahUser").click(function() {
                tambah.style.display = "none"
                batal.style.display = ""
                form.style.display = ""
            })
            $("#btnBatalUser").click(function() {
                tambah.style.display = ""
                batal.style.display = "none"
                form.style.display = "none"
            })

            $('#btn-save').click(function() {
                let nama = document.getElementById('namaUser')
                let jabatan = document.getElementById('jabatan')

                let data = {
                    nama: nama.value,
                    jabatan: jabatan.value
                }

                $.ajax({
                    url: '/user',
                    type: 'POST',
                    data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil di Tambahkan!',
                            text: `User ke ${nama.value} berhasil di Tambahkan.`,
                            icon: 'success',
                            showCancelButton: false,
                            willClose: () => {
                                location.reload();
                            }
                        })
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal di Tambahkan!',
                            `User ke ${nama.value} Gagal di Tambahkan.`,
                            'error'
                        )
                    }
                })
            })

        })
        // edit User

        function btnEdit(nama, jabatan, idUser) {
            document.getElementById(`col-data-${idUser}`).style.display = 'none';
            document.getElementById(`col-update-${idUser}`).style.display = '';
            document.getElementById(`namaUser-${idUser}`).value = nama;
            document.getElementById(`jabatan-${idUser}`).value = jabatan;
        }

        function btnBack(idUser) {
            document.getElementById(`col-data-${idUser}`).style.display = '';
            document.getElementById(`col-update-${idUser}`).style.display = 'none';
            document.getElementById(`namaUser-${idUser}`).value = '';
            document.getElementById(`jabatan-${idUser}`).value = '';
        }

        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Apakah mau hapus Data?',
                text: `data dengan nama ${nama} akan diHapus!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + id).submit();
                    Swal.fire(
                        'Terhapus!',
                        `data dengan nama ${nama} berhasil diHapus!`,
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Batal',
                        'Data tetap aman! :)',
                        'error'
                    )
                }
            })
        }
    </script>

@endsection
