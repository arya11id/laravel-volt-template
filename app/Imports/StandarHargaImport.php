<?php

namespace App\Imports;

use App\Models\StandarHarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StandarHargaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new StandarHarga([
            'kode_kelompok_barang'   => $row['kode_kelompok_barang'],
            'uraian_kelompok_barang'=> $row['uraian_kelompok_barang'],
            'id_standar_harga'      => $row['id_standar_harga'],
            'kode_barang'           => $row['kode_barang'],
            'uraian_barang'         => $row['uraian_barang'],
            'spesifikasi'           => $row['spesifikasi'],
            'satuan'                => $row['satuan'],
            'harga_satuan'          => $row['harga_satuan'],
            'kode_rekening'         => $row['kode_rekening'],
        ]);
    }
}