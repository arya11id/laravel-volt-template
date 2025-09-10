<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkpPegawaiDetail extends Model
{
    use SoftDeletes;

    protected $table = 'skp_pegawai_detail';

    protected $fillable = [
        'uuid',
        'nip',
        'skp_pegawai_id',
        'jenis',
        'status_verifikasi',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];
}