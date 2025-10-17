<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('casos', function (Blueprint $table) {
            $table->id();

            // =====================
            // SECCIÓN REGIONAL
            // =====================
            $table->string('regional_recibe_caso')->nullable();
            $table->date('regional_fecha')->nullable();
            $table->string('nro_registro')->unique(); // ✅ ÚNICO para evitar duplicados
            $table->boolean('nro_registro_manual')->default(false); // ✅ NUEVO: indica si fue manual
            $table->string('regional_institucion_derivante')->nullable();


            // =====================
            // DATOS DEL PACIENTE
            // =====================
            $table->string('paciente_nombres')->nullable();
            $table->string('paciente_apellidos')->nullable();
            $table->integer('paciente_edad')->nullable(); // ✅ CAMBIADO a integer
            $table->string('paciente_ci')->nullable();
            $table->string('paciente_telefono')->nullable();
            $table->string('paciente_calle')->nullable();
            $table->string('paciente_numero')->nullable();
            $table->string('paciente_zona')->nullable();
            $table->string('paciente_id_distrito')->nullable();
            $table->string('paciente_estado_civil')->nullable();
            $table->string('paciente_sexo')->nullable();
            $table->string('paciente_lugar_nacimiento')->nullable();
            $table->string('paciente_lugar_nacimiento_op')->nullable();
            $table->string('paciente_lugar_residencia_op')->nullable(); // ✅ NUEVO
            $table->string('paciente_tiempo_residencia_op')->nullable(); // ✅ NUEVO
            $table->string('paciente_edad_rango')->nullable();
            $table->string('paciente_nivel_instruccion')->nullable();
            $table->string('paciente_idioma_mas_hablado')->nullable(); // ✅ CORREGIDO
            $table->string('paciente_idioma_especificar')->nullable(); 
            $table->string('paciente_ocupacion')->nullable();
            $table->string('paciente_situacion_ocupacional')->nullable();
            $table->text('paciente_otros')->nullable();

            // =====================
            // DATOS DE LA PAREJA
            // =====================
            $table->string('pareja_nombres')->nullable();
            $table->string('pareja_apellidos')->nullable();
            $table->string('pareja_ci')->nullable();
            $table->integer('pareja_edad')->nullable(); // ✅ CAMBIADO a integer
            $table->string('pareja_telefono')->nullable();
            $table->string('pareja_calle')->nullable();
            $table->string('pareja_numero')->nullable();
            $table->string('pareja_zona')->nullable();
            $table->string('pareja_id_distrito')->nullable();
            $table->string('pareja_estado_civil')->nullable();
            $table->string('pareja_sexo')->nullable();
            $table->string('pareja_lugar_nacimiento')->nullable();
            $table->string('pareja_lugar_nacimiento_op')->nullable();
            $table->string('pareja_lugar_residencia_op')->nullable(); // ✅ NUEVO
            $table->string('pareja_tiempo_residencia_op')->nullable(); // ✅ NUEVO
            $table->string('pareja_edad_rango')->nullable();
            $table->string('pareja_nivel_instruccion')->nullable();
            $table->string('pareja_ocupacion_principal')->nullable();
            $table->string('pareja_situacion_ocupacional')->nullable();
            $table->string('pareja_parentesco')->nullable();
            $table->string('pareja_residencia')->nullable();
            $table->string('pareja_tiempo_residencia')->nullable();
            $table->string('pareja_anos_convivencia')->nullable();
            $table->string('pareja_idioma')->nullable();
            $table->string('pareja_especificar_idioma')->nullable();
            $table->text('pareja_otros')->nullable();

            // =====================
            // DATOS DE HIJOS
            // =====================
            $table->string('hijos_num_gestacion')->nullable();
            $table->string('hijos_dependencia')->nullable();
            $table->boolean('hijos_edad_menor4_femenino')->nullable();
            $table->boolean('hijos_edad_menor4_masculino')->nullable();
            $table->boolean('hijos_edad_5_10_femenino')->nullable();
            $table->boolean('hijos_edad_5_10_masculino')->nullable();
            $table->boolean('hijos_edad_11_15_femenino')->nullable();
            $table->boolean('hijos_edad_11_15_masculino')->nullable();
            $table->boolean('hijos_edad_16_20_femenino')->nullable();
            $table->boolean('hijos_edad_16_20_masculino')->nullable();
            $table->boolean('hijos_edad_21_mas_femenino')->nullable();
            $table->boolean('hijos_edad_21_mas_masculino')->nullable();

            // =====================
            // DATOS DE VIOLENCIA - TIPOS
            // =====================
            $table->boolean('violencia_tipo_fisica')->nullable();
            $table->boolean('violencia_tipo_psicologica')->nullable();
            $table->boolean('violencia_tipo_sexual')->nullable();
            $table->boolean('violencia_tipo_patrimonial')->nullable();
            $table->boolean('violencia_tipo_economica')->nullable();
            
            // =====================
            // DATOS DE VIOLENCIA - CARACTERÍSTICAS
            // =====================
            $table->string('violencia_tipo')->nullable(); // ✅ NUEVO (intrafamiliar/domestica)
            $table->string('violencia_frecuancia_agresion')->nullable(); // ✅ NUEVO
            $table->string('violencia_frecuencia')->nullable();
            $table->string('violencia_lugar_hechos')->nullable();
            $table->string('violencia_tiempo_ocurrencia')->nullable();
            $table->text('violencia_descripcion_hechos')->nullable();
            $table->string('violencia_denuncia_previa')->nullable(); // ✅ CAMBIADO a string (si/no)
            $table->string('violencia_institucion_denuncia')->nullable();
            $table->string('violencia_institucion_derivar')->nullable();
            
            // =====================
            // RAZONES DE NO DENUNCIA
            // =====================
            $table->boolean('violencia_no_denuncia_por_amenaza')->nullable(); // ✅ NUEVO
            $table->boolean('violencia_no_denuncia_por_temor')->nullable(); // ✅ NUEVO
            $table->boolean('violencia_no_denuncia_por_verguenza')->nullable(); // ✅ NUEVO
            $table->boolean('violencia_no_denuncia_por_desconocimiento')->nullable(); // ✅ NUEVO
            $table->boolean('violencia_no_denuncia_no_sabe_no_responde')->nullable(); // ✅ NUEVO
            
            // =====================
            // MOTIVO Y ATENCIÓN
            // =====================
            $table->string('violencia_motivo_agresion')->nullable(); // ✅ NUEVO
            $table->string('violencia_motivo_otros')->nullable(); // ✅ NUEVO
            
            // =====================
            // ATENCIÓN DEMANDADA
            // =====================
            $table->string('tipo_atencion')->nullable(); // TIPO DE ATENCION QUE FORMULARIO DE TRES SE USARA
            $table->boolean('violencia_atencion_apoyo_victima')->nullable(); // ✅ NUEVO
            $table->boolean('violencia_atencion_apoyo_pareja')->nullable(); // ✅ NUEVO
            $table->boolean('violencia_atencion_apoyo_agresor')->nullable(); // ✅ NUEVO
            $table->boolean('violencia_atencion_apoyo_hijos')->nullable(); // ✅ NUEVO
            
            // =====================
            // RESPONSABLE DEL FORMULARIO
            // =====================
            $table->string('formulario_responsable_nombre')->nullable(); // ✅ NUEVO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};
