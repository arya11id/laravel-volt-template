<?php

namespace App\Models\Bast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class BastTransaksi extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'bpopp.bast_transaksi';
    public $timestamps = true;

    protected $fillable = [
        'id_bast_unit_kerja',
        'id_trs_nomor_ba',
        'id_pengurus_barang',
        'id_bast_status',
        'nomor_surat',
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