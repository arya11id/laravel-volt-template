<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsSubBl extends Model
{
    use HasFactory;
    protected $table = 'sipdri.unit_kerja';
    protected $primaryKey = 'id_subs_sub_bl';
    public $timestamps = false;
}
