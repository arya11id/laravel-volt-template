<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    // use SoftDeletes;

    protected $table = 'unit_kerja';

    protected $fillable = [
        'id',
        'nama',
    ];
}