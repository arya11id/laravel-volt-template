<?php

namespace App\Models\Bast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class BastUnitKerja extends Model
{
    use HasFactory,  SoftDeletes;
    protected $table = 'bpopp.bast_unit_kerja';
    public $timestamps = true;


    protected $fillable = [
        'nama_unit_kerja',
        'kode_unit_kerja',
        'nip_ks',
        'nama_ks',
        'nip_bendahara',
        'nama_bendahara',
        'jenis',
        'is_active',
        'no_urut',
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
}