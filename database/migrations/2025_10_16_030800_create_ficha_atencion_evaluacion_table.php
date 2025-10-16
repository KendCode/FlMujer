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
        Schema::create('ficha_atencion_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caso_id')->constrained('casos')->onDelete('cascade');
            
            // Datos básicos
            $table->date('fecha');
            $table->string('nro_registro')->nullable();
            $table->integer('edad')->nullable();
            $table->string('nombres_apellidos');
            
            // Sección 2: ¿Buscó ayuda?
            $table->enum('busco_ayuda', ['Si', 'No'])->nullable();
            $table->string('donde_busco_ayuda')->nullable();
            $table->enum('recibio_apoyo', ['Si', 'No'])->nullable();
            $table->string('donde_apoyo')->nullable();
            $table->enum('concluyo_terapia', ['Si', 'No'])->nullable();
            $table->string('cuando_terapia')->nullable();
            $table->text('enfermedades')->nullable();
            
            // Sección 3-8: Evaluación psicológica
            $table->text('motivo_consulta')->nullable();
            $table->text('descripcion_caso')->nullable();
            $table->text('pruebas_psicologicas')->nullable();
            $table->text('conducta_observable')->nullable();
            $table->text('conclusiones_valorativas')->nullable();
            $table->text('fases_intervencion')->nullable();
            
            // Sección 9: Estrategia de intervención
            $table->enum('estrategia', ['Individual', 'Pareja', 'Familia'])->nullable();
            $table->text('detalle_estrategia')->nullable();
            
            // Próxima atención y derivación
            $table->date('fecha_proxima')->nullable();
            $table->json('remito')->nullable(); // Para guardar array de derivaciones
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_atencion_evaluacion');
    }
};
