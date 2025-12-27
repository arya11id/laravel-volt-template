<?php

namespace App\Models\Bast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class BastTrsBastBarang extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'bpopp.bast_trs_bast_barang';
    public $timestamps = true;

    protected $fillable = [
        'id_bast_transaksi',
        'jenis',
        'uraian',
        'volume',
        'id_bast_satuan',
        'harga_satuan',
        'barang_file_name_a',
        'barang_file_path_a',
        'barang_file_name_b',
        'barang_file_path_b',
        'barang_file_name_c',
        'barang_file_path_c',
        'barang_file_name_d',
        'barang_file_path_d',
        'tgl_selesai_nego',
        'tgl_datang_barang',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });

        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }
}