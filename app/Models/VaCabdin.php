<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaCabdin extends Model
{
    use HasFactory;
    protected $table = 'sipdri.va_cabdin';
    protected $primaryKey = 'no';
    public $timestamps = false;
}
