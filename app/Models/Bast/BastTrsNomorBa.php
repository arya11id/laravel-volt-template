<?php

namespace App\Models\Bast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BastTrsNomorBa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bpopp.bast_trs_nomor_ba';
    public $timestamps = true;

    protected $fillable = [
        'id_bast_ms_nomor_ba',
        'tgl_nomor',
        'no_c',
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
    public function bastMsNomorBa()
    {
        return $this->belongsTo(BastMsNomorBa::class, 'id_bast_ms_nomor_ba');
    }
}