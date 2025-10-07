<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pareja extends Model
{
    protected $fillable = [
        'caso_id', 'nombres', 'apellidos', 'sexo', 'edad_rango',
        'estado_civil', 'ocupacion', 'situacion_ocupacional',
    ];

    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }
}
