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
        Schema::create('ficha_seguimiento_psicologicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caso_id'); // Relación con la tabla casos
            $table->date('fecha'); // Fecha de la sesión
            $table->string('nro_registro'); // viene de casos
            $table->integer('nro_sesion'); // número de sesión
            $table->enum('estrategia', ['Individual', 'Pareja', 'Familia'])->nullable();
            $table->string('nombre_apellidos'); // paciente o persona atendida
            $table->text('antecedentes')->nullable();
            $table->text('conducta_observable')->nullable();
            $table->text('conclusiones_valorativas')->nullable();
            $table->text('estrategias_intervencion')->nullable();
            $table->date('fecha_proxima_atencion')->nullable();
            $table->string('nombre_psicologo');
            $table->timestamps();

            $table->foreign('caso_id')->references('id')->on('casos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_seguimiento_psicologicos');
    }
};
