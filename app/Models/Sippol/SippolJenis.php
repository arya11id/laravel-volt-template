<?php

namespace App\Models\Sippol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SippolJenis extends Model
{
    use HasFactory;

    protected $table = 'bpopp.sippol_jenis';

    protected $fillable = [
        'nama_jenis',
        'urutan',
        'nomor',
        'mulai',
        'akhir',
        'is_bm',
        'created_by',
        'updated_by',
        'id_periode','id_kategori'
    ];

    protected $casts = [
        'urutan' => 'integer',
        'nomor' => 'integer',
        'mulai' => 'integer',
        'akhir' => 'integer',
        'is_bm' => 'integer'
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
                    $model->uuid = (string) Str::uuid();
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
    }
}