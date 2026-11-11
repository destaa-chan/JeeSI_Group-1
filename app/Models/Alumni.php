<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    protected $primaryKey = 'id_alumni';
    public $timestamps = false; // Menggunakan kolom manual updated_at saja

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'program_studi',
        'pendidikan',
        'kompetensi',
        'minat_studi',
    ];

    protected function casts(): array
    {
        return [];
    }

    /**
     * Relasi ke User (1-to-1)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Portofolio (1-to-Many)
     */
    public function portofolio(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'id_alumni', 'id_alumni');
    }

    /**
     * Relasi ke Lamaran (1-to-Many)
     */
    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'id_alumni', 'id_alumni');
    }
}
