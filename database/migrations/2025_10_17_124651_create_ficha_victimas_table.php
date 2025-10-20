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
        Schema::create('ficha_victimas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caso_id')->constrained('casos')->onDelete('cascade');
            $table->string('nro_caso')->nullable();
            $table->string('nombres_apellidos')->nullable();
            $table->string('emergencia_nombre')->nullable();
            $table->string('emergencia_telefono')->nullable();
            $table->string('emergencia_parentesco')->nullable();
            $table->json('grupo_familiar')->nullable();
            $table->json('indicadores_decision')->nullable();
            $table->json('indicadores_persona')->nullable();
            $table->json('indicadores_derechos')->nullable();
            $table->json('fases')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('medidas')->nullable();
            $table->date('fecha')->nullable();
            $table->string('recepcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_victimas');
    }
};
