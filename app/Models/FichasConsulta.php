<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichasConsulta extends Model
{

    // Nombre de la tabla (si no sigue la convención plural de Laravel)
    protected $table = 'fichas_consulta';
    protected $primaryKey = 'idFicha';

    protected $fillable = [
        'ci',
        'nombre',
        'apPaterno',
        'apMaterno',
        'numCelular',
        'fecha',
        'instDeriva',
        'testimonio',
        'Penal',
        'Familiar',
        'OtrosProblemas',
        'legal',
        'social',
        'psicologico',
        'espiritual',
    ];

    // Para que automáticamente decodifique/encodee JSON
    protected $casts = [
        'Penal' => 'array',
        'Familiar' => 'array',
        'legal' => 'boolean',
        'social' => 'boolean',
        'psicologico' => 'boolean',
        'espiritual' => 'boolean',
        'fecha' => 'date', 
    ];
}
