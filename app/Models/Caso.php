<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caso extends Model
{
    use HasFactory;

    protected $table = 'casos';

    protected $fillable = [
        // DATOS DEL PACIENTE
        'paciente_nombres',
        'paciente_apellidos',
        'paciente_ci',
        'paciente_telefono',
        'paciente_calle',
        'paciente_numero',
        'paciente_zona',
        'paciente_id_distrito',
        'paciente_estado_civil',
        'paciente_sexo',
        'paciente_lugar_nacimiento',
        'paciente_lugar_nacimiento_op',
        'paciente_edad_rango',
        'paciente_nivel_instruccion',
        'paciente_ocupacion',
        'paciente_situacion_ocupacional',
        'paciente_otros',

        // DATOS DE LA PAREJA
        'pareja_nombres',
        'pareja_apellidos',
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

        // DATOS DE HIJOS
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

        // DATOS DE VIOLENCIA
        'violencia_tipo_fisica',
        'violencia_tipo_psicologica',
        'violencia_tipo_sexual',
        'violencia_tipo_patrimonial',
        'violencia_tipo_economica',
        'violencia_frecuencia',
        'violencia_lugar_hechos',
        'violencia_tiempo_ocurrencia',
        'violencia_descripcion_hechos',
        'violencia_denuncia_previa',
        'violencia_institucion_denuncia',
    ];

}
