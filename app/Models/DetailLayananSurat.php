<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str; // For UUID generation

class DetailLayananSurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_layanan_surat'; // Pastikan nama tabel benar
    protected $fillable = [
        'uuid',
        'layanan_surat_id',
        'tgl_layanan',
        'url_file',
        'keterangan',
        'status_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'tgl_layanan' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Generate UUID automatically on creation
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    // Relationship to LayananSurat
    public function layananSurat()
    {
        return $this->belongsTo(LayananSurat::class, 'layanan_surat_id', 'id');
    }

    // Example relationship to Status (assuming you have this model/table)
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
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
