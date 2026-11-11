<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';
    protected $primaryKey = 'id_lowongan';
    public $timestamps = false;

    protected $fillable = [
        'posisi',
        'deskripsi',
        'kriteria_kandidat',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke Perusahaan (BelongsTo)
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    /**
     * Relasi ke Lamaran (1-to-Many)
     */
    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'id_lowongan', 'id_lowongan');
    }
}
