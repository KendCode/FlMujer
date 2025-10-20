<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FichaVictima extends Model
{
    use HasFactory;

    protected $table = 'ficha_victimas'; // 👈 tu tabla para esta ficha

    protected $fillable = [
        'caso_id',
        'nro_caso',
        'nombres_apellidos',
        'emergencia_nombre',
        'emergencia_telefono',
        'emergencia_parentesco',
        'grupo_familiar',
        'indicadores_decision',
        'indicadores_persona',
        'indicadores_derechos',
        'fases',
        'observaciones',
        'medidas',
        'fecha',
        'recepcion',
    ];

    protected $casts = [
        'grupo_familiar' => 'array',
        'indicadores_decision' => 'array',
        'indicadores_persona' => 'array',
        'indicadores_derechos' => 'array',
        'fases' => 'array',
    ];

    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }
}
