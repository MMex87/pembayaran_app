<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pembayaran Sekolah</title>
</head>

<body>
    <h2>Pembayaran Sekolah untuk {{ $data['namaSiswa'] }}</h2>

    <p>Kepada Wali Kelas {{ $data['namaSiswa'] }},</p>

    <p>Kami pihak administrasi sekolah ingin melampirkan bukti pembayaran.</p>

    <p>Detail pembayaran:</p>
    <ul>
        @foreach ($data['tagihan'] as $value)
            <li>Nama Tagihan: {{ $value->tagihan->namaTagihan->namaTagihan }}</li>
            <li>Harga Tagihan: {{ $value->tagihan->hargaBayar }}</li>
        @endforeach
    </ul>

    <p>Terlampir, kami sertakan Nota pembayaran dalam format PDF. Silakan unduh dan periksa rincian pembayaran.</p>

    <p>Terima kasih atas kerja sama Anda. Kami menghargai kontribusi Anda dalam mendukung pendidikan anak Anda.</p>

    <p>Salam hangat,</p>
    <p>[Tanda Tangan atau Nama Sekolah]<br>[Nama dan Jabatan Pengirim]<br>[Nomor Kontak Pengirim]<br>[Alamat Email
        Pengirim]</p>

</body>

</html>
