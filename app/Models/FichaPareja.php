<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FichaPareja extends Model
{
     use HasFactory;

    protected $table = 'ficha_parejas';

    protected $fillable = [
        'caso_id',
        'nro_caso',
        'nombres_apellidos',
        'observaciones',
        'grupo_familiar',
        'indicadores_pareja',
        'indicadores_hijos',
        'fase_primera',
        'fase_segunda',
        'fase_tercera',
        'fase_cuarta',
        'observacion_fase',
        'medidas',
        'fecha',
        'responsable',
    ];

    protected $casts = [
        'grupo_familiar' => 'array',
        'indicadores_pareja' => 'array',
        'indicadores_hijos' => 'array',
    ];

    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }
}
