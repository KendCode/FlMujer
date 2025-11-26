<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caso extends Model
{
    use HasFactory;

    protected $table = 'casos';

    protected $fillable = [
        'usuario_id', // 🔹 Agregar este campo
        // REGIONAL
        'tipo_atencion',
        'regional_recibe_caso',
        'regional_fecha',
        'nro_registro',
        'nro_registro_manual',
        'regional_institucion_derivante',

        // PACIENTE
        'paciente_nombres',
        'paciente_ap_paterno',               // nuevo
        'paciente_ap_materno',               // nuevo
        'paciente_ci',
        'paciente_edad',
        'paciente_telefono',
        'paciente_calle',
        'paciente_numero',
        'paciente_zona',
        'paciente_id_distrito',
        'paciente_estado_civil',
        'paciente_sexo',
        'paciente_lugar_nacimiento',
        'paciente_lugar_nacimiento_op',
        'paciente_lugar_residencia_op',      // ✅ AGREGAR
        'paciente_tiempo_residencia_op',     // ✅ AGREGAR
        'paciente_edad_rango',
        'paciente_nivel_instruccion',
        'paciente_idioma_mas_hablado',       // ✅ AGREGAR
        'paciente_idioma_especificar',
        'paciente_ocupacion',
        'paciente_situacion_ocupacional',
        'paciente_otros',

        // PAREJA
        'pareja_nombres',
        'pareja_ap_paterno',
        'pareja_ap_materno',
        'pareja_edad',
        'pareja_ci',
        'pareja_telefono',
        'pareja_calle',
        'pareja_numero',
        'pareja_zona',
        'pareja_id_distrito',
        'pareja_estado_civil',
        'pareja_sexo',
        'pareja_lugar_nacimiento',
        'pareja_lugar_nacimiento_op',
        'pareja_lugar_residencia_op',       // ✅ AGREGAR
        'pareja_tiempo_residencia_op',      // ✅ AGREGAR
        'pareja_edad_rango',
        'pareja_nivel_instruccion',
        'pareja_ocupacion_principal',
        'pareja_situacion_ocupacional',
        'pareja_parentesco',
        'pareja_residencia',
        'pareja_tiempo_residencia',
        'pareja_anos_convivencia',
        'pareja_idioma',
        'pareja_especificar_idioma',
        'pareja_otros',

        // HIJOS
        'hijos_num_gestacion',
        'hijos_dependencia',
        'hijos_menor4_m',
        'hijos_menor4_f',
        'hijos_5a10_m',
        'hijos_5a10_f',
        'hijos_11a15_m',
        'hijos_11a15_f',
        'hijos_16a20_m',
        'hijos_16a20_f',
        'hijos_21mas_m',
        'hijos_21mas_f',

        // VIOLENCIA
        'violencia_tipo_fisica',
        'violencia_tipo_psicologica',
        'violencia_tipo_sexual',
        'violencia_tipo_patrimonial',
        'violencia_tipo_economica',
        'violencia_tipo',                            // ✅ AGREGAR
        'violencia_frecuancia_agresion',             // ✅ AGREGAR
        'violencia_frecuencia',
        'violencia_lugar_hechos',
        'violencia_tiempo_ocurrencia',
        'violencia_descripcion_hechos',
        'violencia_denuncia_previa',
        'violencia_no_denuncia_por_amenaza',         // ✅ AGREGAR
        'violencia_no_denuncia_por_temor',           // ✅ AGREGAR
        'violencia_no_denuncia_por_verguenza',       // ✅ AGREGAR
        'violencia_no_denuncia_por_desconocimiento', // ✅ AGREGAR
        'violencia_no_denuncia_no_sabe_no_responde', // ✅ AGREGAR
        'violencia_motivo_agresion',                 // ✅ AGREGAR
        'violencia_motivo_otros',                    // ✅ AGREGAR
        'violencia_atencion_apoyo_victima',          // ✅ AGREGAR
        'violencia_atencion_apoyo_pareja',           // ✅ AGREGAR
        'violencia_atencion_apoyo_agresor',          // ✅ AGREGAR
        'violencia_atencion_apoyo_hijos',            // ✅ AGREGAR
        'violencia_institucion_denuncia',
        'violencia_institucion_derivar',
        'violencia_medidas_tomar',                   // ✅ AGREGAR
        'formulario_responsable_nombre',             // ✅ AGREGAR
    ];
    protected $casts = [
        'regional_fecha' => 'date',
        'nro_registro_manual' => 'boolean',
        'paciente_edad' => 'integer', // ✅ NUEVO
        'pareja_edad' => 'integer', // ✅ NUEVO
        // Hijos


        // Violencia
        'violencia_tipo_fisica' => 'boolean',
        'violencia_tipo_psicologica' => 'boolean',
        'violencia_tipo_sexual' => 'boolean',
        'violencia_tipo_patrimonial' => 'boolean',
        'violencia_tipo_economica' => 'boolean',
        'violencia_no_denuncia_por_amenaza' => 'boolean',
        'violencia_no_denuncia_por_temor' => 'boolean',
        'violencia_no_denuncia_por_verguenza' => 'boolean',
        'violencia_no_denuncia_por_desconocimiento' => 'boolean',
        'violencia_no_denuncia_no_sabe_no_responde' => 'boolean',
        'violencia_atencion_apoyo_victima' => 'boolean',
        'violencia_atencion_apoyo_pareja' => 'boolean',
        'violencia_atencion_apoyo_agresor' => 'boolean',
        'violencia_atencion_apoyo_hijos' => 'boolean',
    ];

    /**
     * Genera el próximo número de registro automático
     */
    public static function generarNumeroRegistro()
    {
        // Obtener el último registro del año actual
        $añoActual = date('y'); // Ej: "25" para 2025

        $ultimoCaso = self::where('nro_registro', 'like', "CT-%-{$añoActual}-EA")
            ->orderBy('nro_registro', 'desc')
            ->first();

        if ($ultimoCaso) {
            // Extraer el número del último registro
            preg_match('/^CT-(\d{3})-\d{2}-EA$/', $ultimoCaso->nro_registro, $matches);
            $ultimoNumero = isset($matches[1]) ? (int)$matches[1] : 0;
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            // Primer registro del año
            $nuevoNumero = 1;
        }

        // Formatear con ceros a la izquierda
        return sprintf('CT-%03d-%s-EA', $nuevoNumero, $añoActual);
    }


    /**
     * Boot method para generar número automáticamente si no existe
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($caso) {
            // Si no tiene número de registro, lo genera automáticamente
            if (empty($caso->nro_registro)) {
                $caso->nro_registro = self::generarNumeroRegistro();
                $caso->nro_registro_manual = false;
            }
        });
    }
    public function fichas()
    {
        return $this->hasMany(FichaAtencionEvaluacion::class, 'caso_id');
    }



    /**
     * Relación con evaluaciones preliminares de HGV
     */
    public function evaluacionesHgv()
    {
        return $this->hasMany(FichaAgresor::class, 'caso_id');
    }

    /**
     * Obtener la evaluación HGV más reciente
     */
    public function evaluacionHgvReciente()
    {
        return $this->hasOne(FichaAgresor::class, 'caso_id')->latestOfMany();
    }

    /**
     * Obtener nombre completo del paciente
     */
    public function getNombreCompletoAttribute()
    {
        return trim($this->paciente_nombres . ' ' . $this->paciente_apellidos);
    }
    /**
     * Relación con el psicólogo asignado
     */
    /**
     * Relación con el psicólogo asignado
     */
    public function psicologo()
    {
        return $this->belongsTo(User::class, 'formulario_responsable_nombre', 'id');
    }
}
