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
            $table->string('nro_registro')->unique();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade'); // ✅ solo esta
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->boolean('denuncio')->nullable();
            $table->string('frecuencia_agresion')->nullable();
            $table->string('tipo_violencia_general')->nullable();
            $table->text('problematica')->nullable();
            $table->text('medidas_tomar_text')->nullable();
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
