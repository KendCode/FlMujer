<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaAtencionEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'ficha_atencion_evaluacion';

    protected $fillable = [
        'caso_id',
        'fecha',
        'nro_registro',
        'nombres_apellidos',
        'edad',
        'busco_ayuda',
        'donde_busco',
        'recibio_apoyo',
        'donde_apoyo',
        'concluyo_terapia',
        'cuando_terapia',
        'enfermedades',
        'motivo_consulta',
        'descripcion_caso',
        'pruebas_psicologicas',
        'conducta_observable',
        'conclusiones_valorativas',
        'fases_intervencion',
        'estrategia',
        'detalle_estrategia',
        'fecha_proxima',
        'remito'
    ];

    // Para que remito (json) se maneje como array automáticamente
    protected $casts = [
        'remito' => 'array',
        'fecha' => 'date',
        'fecha_proxima' => 'date',
    ];
    public function fichasAtencion()
    {
        return $this->hasMany(FichaAtencionEvaluacion::class, 'caso_id');
    }

    /**
     * Relación: Obtener la última ficha de atención
     * 
     * AGREGAR ESTE MÉTODO A TU MODELO CASO EXISTENTE
     */
    public function ultimaFichaAtencion()
    {
        return $this->hasOne(FichaAtencionEvaluacion::class, 'caso_id')
                    ->latestOfMany('fecha');
    }
}
