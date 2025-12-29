<?php

namespace App\Models\SipdRi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KetSubBl extends Model
{
    use HasFactory;

    // 🔹 Schema + table
    protected $table = 'sipdri.ket_sub_bl';

    // 🔹 Primary key
    protected $primaryKey = 'id_ket_sub_bl';

    // 🔹 Incrementing integer
    public $incrementing = false;

    // 🔹 Timestamps manual (karena pakai timestamptz)
    public $timestamps = false;

    // 🔹 Kolom yang boleh diisi
    protected $fillable = [
        'id_bl',
        'id_sub_bl',
        'id_unik',
        'tahun',
        'id_daerah',
        'id_unit',
        'ket_bl_teks',
        'created_user',
        'updated_user',
        'id_skpd',
        'id_sub_skpd',
        'id_program',
        'id_giat',
        'id_sub_giat',
        'nama_bl',
        'nama_sub_bl',
        'nama_daerah',
        'nama_unit',
        'nama_skpd',
        'nama_sub_skpd',
        'nama_program',
        'nama_giat',
        'nama_sub_giat',
        'kode_daerah',
        'kode_unit',
        'kode_skpd',
        'kode_sub_skpd',
        'kode_program',
        'kode_giat',
        'kode_sub_giat',
        'id_jadwal',
        'id_tahun',
        'created_at',
        'updated_at',
    ];
}
