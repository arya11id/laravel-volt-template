<?php

namespace App\Models\Sippol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class SippolPeriode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bpopp.sippol_periode';

    protected $fillable = [
        'nama_periode',
        'tgl',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'tgl' => 'date'
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

        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }
}