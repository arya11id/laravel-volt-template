<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewDpa extends Model
{
    use HasFactory;
    protected $table = 'sipdri.dpa';
    protected $primaryKey = false;
    public $timestamps = false;
}
