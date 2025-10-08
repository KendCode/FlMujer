<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Caso;
use App\Models\Pareja;
use App\Models\Hijo;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'sexo',
        'edad_rango',
        'ci',
        'id_distrito',
        'otros',
        'zona',
        'calle',
        'numero',
        'telefono',
        'lugar_nacimiento',
        'lugar_nacimiento_op',
        'estado_civil',
        'nivel_instruccion',
        'ocupacion',
        'situacion_ocupacional',
    ];
}
