<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaSeguimientoPsicologico extends Model
{
    use HasFactory;

    protected $fillable = [
        'caso_id',
        'fecha',
        'nro_registro',
        'nro_sesion',
        'estrategia',
        'nombre_apellidos',
        'antecedentes',
        'conducta_observable',
        'conclusiones_valorativas',
        'estrategias_intervencion',
        'fecha_proxima_atencion',
        'nombre_psicologo',
    ];

    public function caso()
    {
        //return $this->belongsTo(Caso::class);
        return $this->belongsTo(Caso::class, 'caso_id');
    }

}
