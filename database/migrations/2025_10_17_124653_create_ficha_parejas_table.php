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
        Schema::create('ficha_parejas', function (Blueprint $table) {
            $table->id();
            
            // =====================
            // RELACIÓN CON CASO
            // =====================
            $table->foreignId('caso_id')->nullable()->constrained('casos')->onDelete('cascade');
            
            // =====================
            // DATOS BÁSICOS (se llenan automáticamente desde caso)
            // =====================
            $table->string('nro_caso')->nullable(); // Se llena desde casos.nro_registro
            $table->string('nombres_apellidos')->nullable(); // Se llena desde casos (paciente_nombres + apellidos)
            $table->text('observaciones')->nullable();
            
            // =====================
            // GRUPO FAMILIAR (JSON)
            // =====================
            $table->json('grupo_familiar')->nullable();
            
            // =====================
            // INDICADORES DE VIOLENCIA
            // =====================
            $table->json('indicadores_pareja')->nullable();
            $table->json('indicadores_hijos')->nullable();
            
            // =====================
            // EVALUACIÓN POR FASES
            // =====================
            $table->text('fase_primera')->nullable();
            $table->text('fase_segunda')->nullable();
            $table->text('fase_tercera')->nullable();
            $table->text('fase_cuarta')->nullable();
            $table->text('observacion_fase')->nullable();
            $table->text('medidas')->nullable();
            
            // =====================
            // DATOS FINALES
            // =====================
            $table->date('fecha')->nullable();
            $table->string('responsable')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_parejas');
    }
};
