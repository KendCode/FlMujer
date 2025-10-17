<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caso extends Model
{
    use HasFactory;

    protected $table = 'casos';

    protected $fillable = [
        // REGIONAL
        'tipo_atencion',
        'regional_recibe_caso',
        'regional_fecha',
        'nro_registro',
        'nro_registro_manual',
        'regional_institucion_derivante',

        // PACIENTE
        'paciente_nombres',
        'paciente_apellidos',
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
        'pareja_apellidos',
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
        'hijos_edad_menor4_femenino',
        'hijos_edad_menor4_masculino',
        'hijos_edad_5_10_femenino',
        'hijos_edad_5_10_masculino',
        'hijos_edad_11_15_femenino',
        'hijos_edad_11_15_masculino',
        'hijos_edad_16_20_femenino',
        'hijos_edad_16_20_masculino',
        'hijos_edad_21_mas_femenino',
        'hijos_edad_21_mas_masculino',

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
        'formulario_responsable_nombre',             // ✅ AGREGAR
    ];
    protected $casts = [
        'regional_fecha' => 'date',
        'nro_registro_manual' => 'boolean',
        'paciente_edad' => 'integer', // ✅ NUEVO
        'pareja_edad' => 'integer', // ✅ NUEVO
        // Hijos
        'hijos_edad_menor4_femenino' => 'boolean',
        'hijos_edad_menor4_masculino' => 'boolean',
        'hijos_edad_5_10_femenino' => 'boolean',
        'hijos_edad_5_10_masculino' => 'boolean',
        'hijos_edad_11_15_femenino' => 'boolean',
        'hijos_edad_11_15_masculino' => 'boolean',
        'hijos_edad_16_20_femenino' => 'boolean',
        'hijos_edad_16_20_masculino' => 'boolean',
        'hijos_edad_21_mas_femenino' => 'boolean',
        'hijos_edad_21_mas_masculino' => 'boolean',

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
    public static function generarNumeroRegistro($año = null)
    {
        $año = $año ?? date('y'); // Obtiene el año actual en formato 2 dígitos (25)

        // Busca el último registro del año
        $ultimoRegistro = self::where('nro_registro', 'LIKE', "FLM-{$año}%")
            ->orderBy('nro_registro', 'desc')
            ->first();

        if ($ultimoRegistro) {
            // Extrae el número secuencial del último registro
            $ultimoNumero = (int) substr($ultimoRegistro->nro_registro, -6);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            // Primer registro del año
            $nuevoNumero = 1;
        }

        // Formatea: FLM-25000001
        return sprintf('FLM-%s%06d', $año, $nuevoNumero);
    }

    /**
     * Valida el formato del número de registro manual
     */
    public static function validarFormatoRegistro($registro)
    {
        // Valida formato: FLM-YYNNNNNN (ej: FLM-23000001)
        return preg_match('/^FLM-\d{8}$/', $registro);
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
}
