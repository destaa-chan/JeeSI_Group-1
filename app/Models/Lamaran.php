<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';
    protected $primaryKey = 'id_lamaran';
    public $timestamps = false;

    protected $fillable = [
        'id_lowongan',
        'id_portofolio',
        'cover_letter',
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
     * Relasi ke Lowongan (BelongsTo)
     */
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'id_lowongan', 'id_lowongan');
    }

    /**
     * Relasi ke Portofolio (BelongsTo, nullable)
     */
    public function portofolio(): BelongsTo
    {
        return $this->belongsTo(Portofolio::class, 'id_portofolio', 'id_portofolio');
    }
}
