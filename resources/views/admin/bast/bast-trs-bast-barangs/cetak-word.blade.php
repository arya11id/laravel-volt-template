<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Penyerahan Barang</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.2;
            color: #000;
        }

        /* Gunakan tabel untuk Kop Surat agar posisi logo stabil */
        .header-table {
            width: 100%;
            border-bottom: 3px double #000;
            margin-bottom: 10px;
        }

        .header-text {
            text-align: center;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .item-table th, .item-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .full-table {
            width: 100%;
        }

        .bold-underline {
            font-weight: bold;
            text-decoration: underline;
        }

        /* PHPWord butuh tag <br> untuk spasi tanda tangan, bukan div height */
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="{{ public_path('cabdin.jpg') }}" width="60">
            </td>
            <td width="85%" class="header-text">
                <div style="font-size: 12pt;">PEMERINTAH PROVINSI JAWA TIMUR</div>
                <div style="font-size: 14pt; font-weight: bold;">DINAS PENDIDIKAN</div>
                <div style="font-size: 11pt; font-weight: bold;">CABANG DINAS PENDIDIKAN WILAYAH KEDIRI</div>
                <div style="font-size: 9pt;">Jl. Jaksa Agung Suprapto No. 2 Mojoroto Kota Kediri, Jawa Timur 64112</div>
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-top: 10px;">
        <div style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">BERITA ACARA PENYERAHAN BARANG BELANJA MODAL TAHUN {{$date->year}}</div>
        <div>Nomor : {{ $data->bastTrsNomorBa->bastMsNomorBa->no_a . '/' . $data->bastTrsNomorBa->bastMsNomorBa->no_b }} / {{ $data->bastTrsNomorBa->no_c .'.'. $data->nomor_surat }} / {{ $data->bastTrsNomorBa->bastMsNomorBa->no_d . '/' . $data->bastTrsNomorBa->bastMsNomorBa->no_e }}</div>
    </div>

    <p>Pada hari ini <strong>{{ $hari }}</strong> tanggal <strong>{{ terbilang($date->day) }}</strong> bulan <strong>{{ terbilang($date->month) }}</strong> tahun <strong>{{ terbilang($date->year) }}</strong> yang bertanda tangan dibawah ini :</p>

    <table class="full-table">
        <tr>
            <td width="5%">1.</td>
            <td width="20%">Nama</td>
            <td width="2%">:</td>
            <td>{{ $data->bastPengurusbarang->nama_pengurus }}</td>
        </tr>
        <tr>
            <td></td>
            <td>NIP</td>
            <td>:</td>
            <td>{{ nip($data->bastPengurusbarang->nip_pengurus) }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Jabatan</td>
            <td>:</td>
            <td>Pembantu Pengurus Barang Cabang Dinas Pendidikan Wilayah Kediri, disebut <strong>PIHAK PERTAMA</strong>.</td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
            <td>2.</td>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->bastUnitKerja->nama_bendahara }}</td>
        </tr>
        <tr>
            <td></td>
            <td>NIP</td>
            <td>:</td>
            <td>{{ nip($data->bastUnitKerja->nip_bendahara) }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Jabatan</td>
            <td>:</td>
            <td>Pengadminitrasi Keuangan BPOPP SMKN 3 KOTA KEDIRI, disebut <strong>PIHAK KEDUA</strong>.</td>
        </tr>
    </table>

    <p>PIHAK PERTAMA menyerahkan kepada PIHAK KEDUA barang Belanja Modal sebagai berikut :</p>

    <table class="item-table">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>No</th>
                <th>Jenis Barang</th>
                <th>Spesifikasi</th>
                <th>Vol</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td style="text-align: left;">Kipas Angin</td>
                <td style="text-align: left;">Kipas Angin Besi Dinding Merk MASPION 20 inch</td>
                <td>10 pcs</td>
                <td style="text-align: right;">Rp. 1.275.000</td>
                <td style="text-align: right;">Rp. 12.750.000,-</td>
            </tr>
        </tbody>
    </table>

    <table class="full-table" style="margin-top: 30px; text-align: center;">
        <tr>
            <td width="50%">PIHAK KEDUA</td>
            <td width="50%">PIHAK PERTAMA</td>
        </tr>
        <tr>
            <td height="60"></td> <td height="60"></td>
        </tr>
        <tr>
            <td><span class="bold-underline">{{ $data->bastUnitKerja->nama_bendahara }}</span><br>NIP. {{ nip($data->bastUnitKerja->nip_bendahara) }}</td>
            <td><span class="bold-underline">{{ $data->bastPengurusbarang->nama_pengurus }}</span><br>NIP. {{ nip($data->bastPengurusbarang->nip_pengurus) }}</td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 30px;">
                Mengetahui,<br>
                KEPALA {{ $data->bastUnitKerja->nama_unit_kerja }}<br><br><br><br>
                <span class="bold-underline">{{ $data->bastUnitKerja->nama_ks }}</span><br>
                NIP. {{ nip($data->bastUnitKerja->nip_ks) }}
            </td>
        </tr>
    </table>

    <br clear="all" style="page-break-before:always" />
    
    <div style="text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px;">
        BUKTI DOKUMENTASI PENYERAHAN BARANG BELANJA MODAL TAHUN 2025
    </div>

    <table class="full-table">
        @foreach ($bastTrsBastBarang as $item)
            <tr>
                <td colspan="2" style="text-align: center; padding: 10px;"><strong>{{$item->uraian}}</strong></td>
            </tr>
            <tr>
                @if ($item->barang_file_name_a)
                <td style="text-align: center; border: 1px solid #ccc; padding: 5px;">
                    <img src="{{ storage_path('app/public/bast-barang/' . $item->barang_file_name_a) }}" style="width: 250px;">
                </td>
                @endif
                @if ($item->barang_file_name_b)
                <td style="text-align: center; border: 1px solid #ccc; padding: 5px;">
                    <img src="{{ storage_path('app/public/bast-barang/' . $item->barang_file_name_b) }}" style="width: 250px;">
                </td>
                @endif
            </tr>
        @endforeach
    </table>

</body>
</html>