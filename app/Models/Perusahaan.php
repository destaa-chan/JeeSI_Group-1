<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';
    public $timestamps = false; // Menggunakan created_at dan updated_at manual (datetime)

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke User (1-to-1)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Lowongan (1-to-Many)
     */
    public function lowongan(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
