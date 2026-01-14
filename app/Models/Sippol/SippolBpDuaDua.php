<?php

namespace App\Models\Sippol;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
// use Illuminate\Database\Eloquent\SoftDeletes;

class SippolBpDuaDua extends Model
{
    use HasFactory;

    protected $table = 'bpopp.sippol_bast_bpduadua';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_periode',
        'id_unit_kerja',
        'jenis',
        'nomor',
        'tanggal',
        'sekolah',
        'kode',
        'uraian',
        'penerimaan',
        'pengeluaran',
        'id_sippol_jenis',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'id_periode' => 'integer',
        'id_unit_kerja' => 'integer',
        'penerimaan' => 'integer',
        'pengeluaran' => 'integer',
        'id_sippol_jenis' => 'integer'
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
    public function periode()
    {
        return $this->belongsTo(SippolPeriode::class, 'id_periode');
    }
    public function unitkerja()
    {
        return $this->belongsTo(SippolUnitKerja::class, 'id_unit_kerja');
    }
    public function jenisbp22()
    {
        return $this->belongsTo(SippolJenis::class, 'id_sippol_jenis');
    }
}