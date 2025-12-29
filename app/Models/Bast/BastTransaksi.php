<?php

namespace App\Models\Bast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BastTransaksi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bpopp.bast_transaksi';
    public $timestamps = true;

    protected $fillable = [
        'id_bast_unit_kerja',
        'id_trs_nomor_ba',
        'id_pengurus_barang',
        'id_bast_status',
        'nomor_surat',
        'surat_pesanan_path',
        'surat_pesanan_file',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->uuid = (string) Str::uuid();
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
    public function bastUnitKerja()
    {
        return $this->belongsTo(BastUnitKerja::class, 'id_bast_unit_kerja');
    }
    public function bastTrsNomorBa()
    {
        return $this->belongsTo(BastTrsNomorBa::class, 'id_trs_nomor_ba');
    }
    public function bastPengurusbarang()
    {
        return $this->belongsTo(BastPengurusbarang::class, 'id_pengurus_barang');
    }
    public function bastStatus()
    {
        return $this->belongsTo(BastStatus::class, 'id_bast_status');
    }
}