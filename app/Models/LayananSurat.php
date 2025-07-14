<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str; // For UUID generation

class LayananSurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'layanan_surat'; // Pastikan nama tabel benar
    protected $fillable = [
        'uuid',
        'no_surat',
        'tgl_surat',
        'keterangan',
        'jenis_layanan_id',
        'tgl_pengajuan',
        'tgl_selesai',
        'url_file',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'tgl_surat' => 'date',
        'tgl_pengajuan' => 'date',
        'tgl_selesai' => 'date',
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

    // Relationship to DetailLayananSurat
    public function details()
    {
        return $this->hasMany(DetailLayananSurat::class, 'layanan_surat_id', 'id');
    }

    // Example relationship to JenisLayanan (assuming you have this model/table)
    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id', 'id');
    }
}
