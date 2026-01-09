<?php

namespace App\Models\SipdRi;
use Illuminate\Database\Eloquent\Model;

class StandarHarga extends Model
{
    protected $table = 'sipdri.standar_hargas';

    protected $fillable = [
        'kode_kelompok_barang',
        'uraian_kelompok_barang',
        'id_standar_harga',
        'kode_barang',
        'uraian_barang',
        'spesifikasi',
        'satuan',
        'harga_satuan',
        'kode_rekening',
        'jenis',
        'id_tahun',
    ];
}