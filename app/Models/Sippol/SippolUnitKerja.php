<?php

namespace App\Models\Sippol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SippolUnitKerja extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'bpopp.sippol_unit_kerja';
    public $timestamps = true;

    protected $fillable = [
        'id_bast_unit_kerja',
        'jml_gu',
        'jml_sts',
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