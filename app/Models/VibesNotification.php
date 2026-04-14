<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VibesNotification extends Model
{
    protected $table = 'vibes_notifications';

    protected $fillable = [
        'mensaje',
        'tipo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // ─── Obtener mensaje aleatorio activo ─────────────────────────────
    public static function getRandom(): ?self
    {
        return self::where('activo', true)
            ->inRandomOrder()
            ->first();
    }

    // ─── Obtener mensaje por tipo ─────────────────────────────────────
    public static function getByTipo(string $tipo): ?self
    {
        return self::where('activo', true)
            ->where('tipo', $tipo)
            ->inRandomOrder()
            ->first();
    }
}