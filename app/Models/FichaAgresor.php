<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FichaAgresor extends Model
{
    use HasFactory;

    protected $table = 'evaluacion_preliminar_hgv';

    protected $fillable = [
        'caso_id',
        'nro_registro',
        'nombre_completo',
        'contacto_emergencia',
        'telf_emergencia',
        'relacion_emergencia',
        'grupo_familiar',
        'fase_primera',
        'fase_segunda',
        'fase_tercera',
        'fase_cuarta',
        'indicadores',
        'observaciones',
        'medidas_tomar',
        'recepcionador',
        'fecha',
    ];

    protected $casts = [
        'grupo_familiar' => 'array',
        'indicadores' => 'array',
        'fecha' => 'date',
    ];

    /**
     * Relación con la tabla casos
     */
    public function caso()
    {
        return $this->belongsTo(Caso::class, 'caso_id');
    }

    /**
     * Obtener el nombre completo desde el caso relacionado
     */
    public function getNombreCompletoAttribute($value)
    {
        return $value ?? ($this->caso ? 
            trim($this->caso->paciente_nombres . ' ' . $this->caso->paciente_apellidos) : 
            null);
    }

    /**
     * Obtener indicadores por categoría
     */
    public function getIndicadoresPorCategoria()
    {
        $indicadores = $this->indicadores ?? [];
        
        return [
            'a' => array_filter($indicadores, fn($i) => str_starts_with($i, 'a_')),
            'b' => array_filter($indicadores, fn($i) => str_starts_with($i, 'b_')),
            'c' => array_filter($indicadores, fn($i) => str_starts_with($i, 'c_')),
        ];
    }

    /**
     * Contar total de miembros del grupo familiar
     */
    public function getTotalMiembrosFamiliares()
    {
        return count($this->grupo_familiar ?? []);
    }
}
