<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolio';
    protected $primaryKey = 'id_portofolio';
    public $timestamps = false;

    protected $fillable = [
        'nama_portofolio',
        'deskripsi',
        'file_portofolio',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke Alumni (BelongsTo)
     */
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }

    /**
     * Relasi ke Lamaran (1-to-Many)
     */
    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'id_portofolio', 'id_portofolio');
    }
}
