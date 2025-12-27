<?php

namespace App\Models\Bast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class BastPengurusbarang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bpopp.bast_pengurus_barang';
    public $timestamps = true;

    protected $fillable = [
        'nama_pengurus',
        'nip_pengurus',
        'is_active',
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