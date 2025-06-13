<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailLayanan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'detail_layanan';
    protected $fillable = [
        'uuid',
        'jenis_layanan_id',
        'pemohon_id',
        'tgl_pengajuan',
        'tgl_selesai',
        'url_file',
        'keterangan',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $casts = [
        'tgl_pengajuan' => 'date',
        'tgl_selesai' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id', 'id');
    }
    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class, 'pemohon_id', 'id');
    }
    public function riwayatLayanan()
    {
        return $this->hasMany(RiwayatLayanan::class, 'detail_layanan_id', 'id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
}
