<?php

namespace App\Models\Sippol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Bast\BastUnitKerja;

class SippolUnitKerja extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bpopp.sippol_unit_kerja';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_bast_unit_kerja',
        'jml_gu',
        'jml_sts',
        'id_periode',
        'kode',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'id_bast_unit_kerja' => 'integer',
        'jml_gu' => 'integer',
        'jml_sts' => 'integer',
        'id_periode' => 'integer'
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
        static::addGlobalScope('orderByNoUrut', function (Builder $builder) {
            $builder
                ->join('bpopp.bast_unit_kerja', 'bpopp.bast_unit_kerja.id', '=', 'bpopp.sippol_unit_kerja.id_bast_unit_kerja')
                ->orderBy('bpopp.bast_unit_kerja.no_urut');
        });
    }
    public function bastUnitKerja()
    {
        return $this->belongsTo(BastUnitKerja::class, 'id_bast_unit_kerja');
    }
}