<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ $judul == 'Dashboard' ? '' : 'collapsed' }}" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Mastering</li>

        <li class="nav-item">
            <a class="nav-link {{ $judul == 'Kelas' ? '' : 'collapsed' }}" href="/kelas">
                <i class="bi bi-house-door"></i><span>Kelas</span>
            </a>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link {{ $judul == 'Siswa' ? '' : 'collapsed' }}" href="/siswa">
                <i class="bi bi-person"></i><span>Siswa</span>
            </a>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link {{ $judul == 'Tagihan' ? '' : 'collapsed' }}" href="/tagihan">
                <i class="bi bi-file-text"></i><span>Tagihan</span>
            </a>
        </li><!-- End Components Nav -->

        <li class="nav-heading">Transaksi</li>

        <li class="nav-item">
            <a class="nav-link {{ $judul == 'Pemayaran' ? '' : 'collapsed' }}" href="/pembayaran">
                <i class="bi bi-file-ruled"></i><span>Pembayaran</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $judul == 'TagihanSiswa' ? '' : 'collapsed' }}" href="/TagihanSiswa">
                <i class="bi bi-journal-text"></i><span>Tagihan Per Siswa</span>
            </a>
        </li>

    </ul>

</aside>
