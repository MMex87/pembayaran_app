@extends('layouts.template')

@section('title', 'Kelas {{ $kelas->namaKelas }}')

@section('main')
    <div class="pagetitle">
        <h1>Detail Kelas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/kelas">Kelas</a></li>
                <li class="breadcrumb-item active">Kelas {{ $kelas->namaKelas }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Siswa</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Wali Kelas</div>
                                    <div class="col-lg-9 col-md-8">{{ $kelas->waliKelas }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Email Wali Kelas</div>
                                    <div class="col-lg-9 col-md-8">{{ $kelas->emailWaliKelas }}</div>
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="/kelas/{{ $kelas->idkelas }}/edit" class="btn btn-warning"><i
                                        class="bi bi-pencil-square"></i></a>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <div class="datatable-dropdown">
                                    <label>
                                        <select class="datatable-selector">
                                            <option value="5">5</option>
                                            <option value="10" selected="">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select> entries per page
                                    </label>
                                </div>
                                <div class="datatable-search">
                                    <input class="datatable-input" placeholder="Search..." type="search"
                                        title="Search within table">
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 5.691964285714286%;"><a href="#"
                                                    class="datatable-sorter">#</a></th>
                                            <th data-sortable="true" style="width: 28.013392857142854%;"><a href="#"
                                                    class="datatable-sorter">Name</a></th>
                                            <th data-sortable="true" style="width: 37.723214285714285%;"><a href="#"
                                                    class="datatable-sorter">Position</a></th>
                                            <th data-sortable="true" style="width: 9.263392857142858%;"><a href="#"
                                                    class="datatable-sorter">Age</a></th>
                                            <th data-sortable="true" style="width: 19.308035714285715%;"><a href="#"
                                                    class="datatable-sorter">Start Date</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-index="0">
                                            <td>1</td>
                                            <td>Brandon Jacob</td>
                                            <td>Designer</td>
                                            <td>28</td>
                                            <td>2016-05-25</td>
                                        </tr>
                                        <tr data-index="1">
                                            <td>2</td>
                                            <td>Bridie Kessler</td>
                                            <td>Developer</td>
                                            <td>35</td>
                                            <td>2014-12-05</td>
                                        </tr>
                                        <tr data-index="2">
                                            <td>3</td>
                                            <td>Ashleigh Langosh</td>
                                            <td>Finance</td>
                                            <td>45</td>
                                            <td>2011-08-12</td>
                                        </tr>
                                        <tr data-index="3">
                                            <td>4</td>
                                            <td>Angus Grady</td>
                                            <td>HR</td>
                                            <td>34</td>
                                            <td>2012-06-11</td>
                                        </tr>
                                        <tr data-index="4">
                                            <td>5</td>
                                            <td>Raheem Lehner</td>
                                            <td>Dynamic Division Officer</td>
                                            <td>47</td>
                                            <td>2011-04-19</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                <div class="datatable-info">Showing 1 to 5 of 5 entries</div>
                                <nav class="datatable-pagination">
                                    <ul class="datatable-pagination-list"></ul>
                                </nav>
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
