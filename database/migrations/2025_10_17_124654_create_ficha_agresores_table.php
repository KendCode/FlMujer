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
        Schema::create('ficha_agresores', function (Blueprint $table) {
            $table->id();
            
            // =====================
            // RELACIÓN CON CASOS
            // =====================
            $table->foreignId('caso_id')->constrained('casos')->onDelete('cascade');
            // Campos duplicados para facilitar búsquedas (desnormalización controlada)
            $table->string('nro_registro')->index();
            $table->string('nombre_completo');
            
            // =====================
            // CONTACTO DE EMERGENCIA
            // =====================
            $table->string('contacto_emergencia')->nullable();
            $table->string('telf_emergencia')->nullable();
            $table->string('relacion_emergencia')->nullable();
            
            // =====================
            // GRUPO FAMILIAR (JSON)
            // =====================
            $table->json('grupo_familiar')->nullable();
            // Estructura esperada:
            // [
            //   {
            //     "nombre": "Juan Pérez",
            //     "parentesco": "Hijo",
            //     "edad": 15,
            //     "sexo": "M",
            //     "grado": "Secundaria",
            //     "estado_civil": "Soltero",
            //     "ocupacion": "Estudiante",
            //     "lugar": "Colegio X",
            //     "observacion": "Buen rendimiento"
            //   }
            // ]
            
            // =====================
            // EVALUACIÓN POR FASES
            // =====================
            $table->text('fase_primera')->nullable();
            $table->text('fase_segunda')->nullable();
            $table->text('fase_tercera')->nullable();
            $table->text('fase_cuarta')->nullable();
            
            // =====================
            // INDICADORES DE VIOLENCIA (JSON)
            // =====================
            $table->json('indicadores')->nullable();
            // Estructura esperada: ["a_0", "a_3", "b_1", "c_2", ...]
            
            // =====================
            // OBSERVACIONES Y MEDIDAS
            // =====================
            $table->text('observaciones')->nullable();
            $table->text('medidas_tomar')->nullable();
            
            // =====================
            // RESPONSABLE
            // =====================
            $table->string('recepcionador')->nullable();
            $table->date('fecha')->nullable();
            
            $table->timestamps();
            
            // =====================
            // ÍNDICES
            // =====================
            $table->index(['caso_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_agresores');
    }
};
