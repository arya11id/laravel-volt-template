<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkpPegawai extends Model
{
    use SoftDeletes;

    protected $table = 'skp_pegawai';

    protected $fillable = [
        'uuid',
        'bulan',
        'batch',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['batch', 'deleted_at'];
}