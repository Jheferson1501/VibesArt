<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    protected $table = 'streaks';

    protected $fillable = [
        'user_id',
        'dias_racha',
        'racha_maxima',
        'ultimo_registro',
    ];

    protected $casts = [
        'ultimo_registro' => 'date',
        'dias_racha'      => 'integer',
        'racha_maxima'    => 'integer',
    ];

    // ─── Relación con usuario ─────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Actualizar racha ─────────────────────────────────────────────
    public function actualizar(): void
    {
        $hoy = today();

        if (!$this->ultimo_registro) {
            // Primera vez
            $this->dias_racha     = 1;
            $this->ultimo_registro = $hoy;
        } elseif ($this->ultimo_registro->isYesterday()) {
            // Día consecutivo
            $this->dias_racha++;
            $this->ultimo_registro = $hoy;
        } elseif (!$this->ultimo_registro->isToday()) {
            // Se rompió la racha
            $this->dias_racha     = 1;
            $this->ultimo_registro = $hoy;
        }

        // Actualizar racha máxima
        if ($this->dias_racha > $this->racha_maxima) {
            $this->racha_maxima = $this->dias_racha;
        }

        $this->save();
    }
}