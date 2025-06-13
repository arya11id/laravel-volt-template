<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatLayanan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'riwayat_layanan';
    protected $fillable = [
        'uuid',
        'detail_layanan_id',
        'tgl_layanan',
        'url_file',
        'keterangan',
        'status_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $casts = [
        'tgl_layanan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function detailLayanan()
    {
        return $this->belongsTo(DetailLayanan::class, 'detail_layanan_id', 'id');
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
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
