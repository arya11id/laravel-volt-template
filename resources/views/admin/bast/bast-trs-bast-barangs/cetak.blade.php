<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Penyerahan Barang - SMKN 3 Kediri</title>
    <style>
        /* Konfigurasi Halaman A4 */
        @page {
            size: A4;
            margin: 1cm 2cm; /* Margin diperkecil untuk menghemat ruang */
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.2; /* Line-height diperapat */
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Lebih Rapat */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #000;
            border-bottom-style: double;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .header-logo {
            width: 70px;
            vertical-align: middle;
            padding-right: 12px;
        }

        .header-logo img {
            width: 85px;
            height: auto;
        }

        .header-text {
            text-align: center;
            vertical-align: middle;
        }

        .header-text h1 {
            margin: 0;
            padding: 0;
            font-size: 14pt;
            font-weight: bold;
            line-height: 1.1;
        }

        .header-text h2 {
            margin: 0;
            padding: 0;
            font-size: 14pt;
            font-weight: normal;
            line-height: 1.1;
        }

        .header-text h3 {
            margin: 0;
            padding: 0;
            font-size: 10pt;
            font-weight: normal;
        }

        .header-text p {
            margin: 0;
            padding: 0;
            font-size: 10pt;
            line-height: 1.2;
        }

        /* Judul Dokumen */
        .title-container {
            text-align: center;
            margin-bottom: 10px;
        }

        .title-container h4 {
            text-decoration: underline;
            margin-bottom: 0;
            font-size: 11pt;
            text-transform: uppercase;
        }

        .title-container p {
            margin-top: 2px;
            font-size: 12pt;
        }

        /* Konten */
        .content {
            text-align: justify;
        }

        .content p {
            margin: 5px 0;
        }

        .party-table {
            width: 100%;
            margin-left: 15px;
            margin-bottom: 5px;
        }

        .party-table td {
            vertical-align: top;
            padding: 1px 0;
        }

        .party-table td:first-child {
            width: 100px;
        }

        .party-table td:nth-child(2) {
            width: 10px;
        }

        /* Tabel Barang */
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2px 0;
        }

        .item-table th, .item-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            font-size: 10pt;
        }

        .item-table th {
            background-color: #f2f2f2;
        }

        .text-left { text-align: left; }
        .text-right { text-align: right; }

        /* Tanda Tangan */
        .signature-container {
            margin-top: 15px;
            width: 100%;
        }

        .signature-row {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .signature-col {
            display: table-cell;
            text-align: center;
            vertical-align: top;
        }

        .signature-space {
            height: 50px; /* Diperkecil agar muat di halaman 1 */
        }

        .name-bold {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0;
        }

        .nip-text {
            margin-top: 0;
            font-size: 10pt;
        }

        /* Halaman Baru */
        .page-break {
            page-break-before: always;
        }

        .appendix-title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        /* Foto Grid */
        .photo-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .photo-box {
            width: 50%;
            height: 180px;
            border: 1px dashed #000;
            text-align: center;
            vertical-align: middle;
            background-color: #fafafa;
        }

        .photo-label {
            margin-top: 3px;
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
        }

        .placeholder-text {
            color: #888;
            font-style: italic;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <!-- HALAMAN 1: BERITA ACARA -->
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('cabdin.jpg') }}" alt="Logo Pemprov Jatim">
            </td>
            <td class="header-text">
                <h2>PEMERINTAH PROVINSI JAWA TIMUR DINAS PENDIDIKAN</h2>
                <h1>CABANG DINAS PENDIDIKAN WILAYAH KEDIRI</h1>
                <h3>(KABUPATEN – KOTA KEDIRI)</h3>
                <p>Jl. Jaksa Agung Suprapto No. 2 Mojoroto Kota Kediri, Jawa Timur 64112</p>
                <p>Telp. & Fax. (0354) 6021727 Laman: www.kediricab.dindik.jatimprov.go.id</p>
                <p>E-mail: cabdin.kediri@gmail.com</p>
            </td>
        </tr>
    </table>

    <div class="title-container">
        <h4>BERITA ACARA PENYERAHAN BARANG BELANJA MODAL TAHUN {{$date->year}}</h4>
        <p>Nomor : {{ $data->bastTrsNomorBa->bastMsNomorBa->no_a . '/' . $data->bastTrsNomorBa->bastMsNomorBa->no_b }} / {{  $data->bastTrsNomorBa->no_c .'.'. $data->nomor_surat }} / {{ $data->bastTrsNomorBa->bastMsNomorBa->no_d . '/' . $data->bastTrsNomorBa->bastMsNomorBa->no_e }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini <strong>{{ $hari }}</strong> tanggal <strong>{{ terbilang($date->day) }}</strong> bulan <strong>{{ terbilang($date->month) }}</strong> tahun <strong>{{ terbilang($date->year) }}</strong> yang bertanda tangan dibawah ini :</p>
        
        <table class="party-table">
            <tr>
                <td>1. Nama</td>
                <td>:</td>
                <td>{{ $data->bastPengurusbarang->nama_pengurus }}</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;NIP</td>
                <td>:</td>
                <td>{{ nip($data->bastPengurusbarang->nip_pengurus) }}</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;Jabatan</td>
                <td>:</td>
                <td>Pembantu Pengurus Barang Cabang Dinas Pendidikan Wilayah Kediri, selanjutnya disebut <strong>PIHAK PERTAMA</strong>.</td>
            </tr>
        </table>

        <table class="party-table">
            <tr>
                <td>2. Nama</td>
                <td>:</td>
                <td>{{ $data->bastUnitKerja->nama_bendahara }}</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;NIP</td>
                <td>:</td>
                <td>{{ nip($data->bastUnitKerja->nip_bendahara) }}</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;Jabatan</td>
                <td>:</td>
                <td>Pengadminitrasi Keuangan BPOPP {{ $data->bastUnitKerja->nama_unit_kerja }}, selanjutnya disebut <strong>PIHAK KEDUA</strong>.</td>
            </tr>
        </table>

        <p>Kedua belah pihak dengan ini menyatakan bahwa :</p>
        <ol style="margin: 5px 0;">
            <li>PIHAK PERTAMA menyerahkan kepada PIHAK KEDUA barang Belanja Modal dengan spesifikasi sebagai berikut :</li>
        </ol>

        <table class="item-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Jenis Barang</th>
                    <th width="30%">Spesifikasi</th>
                    <th width="10%">Vol</th>
                    <th width="15%">Harga Satuan</th>
                    <th width="20%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bastTrsBastBarang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $item->jenis }}</td>
                    <td class="text-left">{{ $item->uraian }}</td>
                    <td>{{ $item->volume }}</td>
                    <td class="text-right">Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp. {{ number_format($item->harga_satuan * $item->volume, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">JUMLAH</th>
                    <th class="text-right">Rp. {{ number_format($bastTrsBastBarang->sum(fn($item) => $item->harga_satuan * $item->volume), 0, ',', '.') }},-</th>
                </tr>
            </tfoot>
        </table>

        <ol start="2" style="margin: 5px 0;">
            <li>Segala tanggung jawab PIHAK PERTAMA atas barang dimaksud beralih ke PIHAK KEDUA ;</li>
            <li>Berita Acara ini dibuat rangkap 3 (tiga) untuk PIHAK PERTAMA, PIHAK KEDUA dan Arsip.</li>
        </ol>
    </div>

    <div class="signature-container">
        <div class="signature-row">
            <div class="signature-col">
                <p>PIHAK KEDUA</p>
                <div class="signature-space"></div>
                <p class="name-bold">{{ $data->bastUnitKerja->nama_bendahara }}</p>
                <p class="nip-text">NIP. {{ nip($data->bastUnitKerja->nip_bendahara) }}</p>
            </div>
            <div class="signature-col">
                <p>PIHAK PERTAMA</p>
                <div class="signature-space"></div>
                <p class="name-bold">{{ $data->bastPengurusbarang->nama_pengurus }}</p>
                <p class="nip-text">NIP. {{ nip($data->bastPengurusbarang->nip_pengurus) }}</p>
            </div>
        </div>
        
        <div class="signature-row" style="margin-top: 10px;">
            <div class="signature-col" style="width: 100%;">
                <p>KEPALA {{ $data->bastUnitKerja->nama_unit_kerja }}</p>
                <div class="signature-space"></div>
                <p class="name-bold">{{ $data->bastUnitKerja->nama_ks }}</p>
                <p class="nip-text">NIP. {{ nip($data->bastUnitKerja->nip_ks) }}</p>
            </div>
        </div>
    </div>

    <!-- HALAMAN 2: DOKUMENTASI FOTO -->
    <div class="page-break"></div>
    
    {{-- <div class="appendix-title">
        BUKTI DOKUMENTASI PENYERAHAN BARANG BELANJA MODAL TAHUN 2025
    </div> --}}

    <table class="photo-grid">
        <tbody>
            @foreach ($bastTrsBastBarang as $item)
                <tr>
                    <td colspan="2" style="text-align: center;"><strong>{{$item->uraian}}</strong></td>
                </tr>
                @if ($item->barang_file_name_a || $item->barang_file_name_b)
                <tr>
                    @if ($item->barang_file_name_a)
                    <td style="width: 50%; text-align: center;"><img src="{{ storage_path('app/public/bast-barang/' . $item->barang_file_name_a) }}" style="width: 90%; height: auto; margin: auto;"></td>
                    @endif
                    @if ($item->barang_file_name_b)
                    <td style="width: 50%; text-align: center;"><img src="{{ storage_path('app/public/bast-barang/' . $item->barang_file_name_b) }}" style="width: 90%; height: auto; margin: auto;"></td>
                    @endif
                </tr>
                @endif
                @if ($item->barang_file_name_c || $item->barang_file_name_d)
                <tr>
                    @if ($item->barang_file_name_c)
                    <td style="width: 50%; text-align: center;"><img src="{{ storage_path('app/public/bast-barang/' . $item->barang_file_name_c) }}" style="width: 90%; height: auto; margin: auto;"></td>
                    @endif
                    @if ($item->barang_file_name_d)
                    <td style="width: 50%; text-align: center;"><img src="{{ storage_path('app/public/bast-barang/' . $item->barang_file_name_d) }}" style="width: 90%; height: auto; margin: auto;"></td>
                    @endif
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>