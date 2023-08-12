@extends('layouts.template')

@section('title', 'Nama Tagihan')

@section('main')

    <div class="pagetitle">
        <h1>Nama Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/tagihan">Tagihan</a></li>
                <li class="breadcrumb-item"><a href="/tagihan/create">Tambah Tagihan</a></li>
                <li class="breadcrumb-item active">Nama Tagihan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Tagihan</h5>
                        <!-- Table with stripped rows -->
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <a href="/namaTagihan/create" class="btn btn-success">Tambah Tagihan <i
                                        class="bi bi-plus-lg"></i></a>
                                <div class="datatable-search">
                                    <input class="datatable-input" placeholder="Search..." type="search"
                                        title="Search within table">
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 5%;">#</th>
                                            <th data-sortable="true" style="width: 55%;">Nama Tagihan</th>
                                            <th data-sortable="true" style="width: 40%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @foreach ($namaTagihan as $value)
                                            <tr data-index="{{ $index }}" id="col-data">
                                                <td>{{ $index }}</td>
                                                <td>{{ $value->namaTagihan }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-evenly">
                                                        <a onclick="btnEdit('{{ $value->namaTagihan }}')"
                                                            class="btn btn-warning">Edit</a>
                                                        <form action="namaTagihan/{{ $value->idNamaTagihan }}"
                                                            method="POST" id="deleteForm{{ $value->idNamaTagihan }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="confirmDelete('{{ $value->idNamaTagihan }}')">Hapus</button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-index="{{ $index }}" id="col-update" style="display: none;">
                                                <form action="/namaTagihan/{{ $value->idNamaTagihan }}" method="POST">
                                                    @method('PATCH')
                                                    @csrf
                                                    <td>{{ $index }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" id="namaTagihan"
                                                            name="namaTagihan">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-evenly">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <a onclick="btnBack()" class="btn btn-warning">back</a>
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
                                {{ $namaTagihan->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>



    <script>
        function btnEdit(namaTagihan) {
            document.getElementById('col-data').style.display = 'none';
            document.getElementById('col-update').style.display = '';
            document.getElementById('namaTagihan').value = namaTagihan;
        }

        function btnBack() {
            document.getElementById('col-data').style.display = '';
            document.getElementById('col-update').style.display = 'none';
            document.getElementById('namaTagihan').value = '';
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + id).submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endsection
