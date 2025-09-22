<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemohon extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pemohon';
    protected $fillable = [
        'uuid',
        'nip',
        'no_hp',
        'nama',
        'tgl_lahir',
        'asal_instansi',
        'alamat',
        'created_by',
        'updated_by',
        'deleted_by',
        'id_unit_kerja',
    ];
    // protected $casts = [
    //     'tgl_lahir' => 'date',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    //     'deleted_at' => 'datetime',
    // ];
    public function detailLayanan()
    {
        return $this->hasMany(DetailLayanan::class, 'pemohon_id', 'id');
    }
    public function unitKerja()
    {
        return $this->hasOne(unitKerja::class, 'id', 'id_unit_kerja');
    }

}
