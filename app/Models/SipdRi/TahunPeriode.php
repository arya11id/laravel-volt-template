<?php

namespace App\Models\SipdRi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPeriode extends Model
{
    use HasFactory;
    protected $table = 'sipdri.tahun_periode';
    protected $fillable = [
        'tahun',
    ];
}
