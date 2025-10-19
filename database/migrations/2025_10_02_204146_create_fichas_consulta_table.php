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
        Schema::create('fichas_consulta', function (Blueprint $table) {
            $table->id('idFicha');

            // Datos del paciente
            $table->string('ci', 9)->unique();
            $table->string('nombre', 100);
            $table->string('apPaterno', 100);
            $table->string('apMaterno', 100)->nullable();
            $table->string('numCelular', 8)->nullable();

            // Datos de la consulta
            $table->date('fecha');
            $table->string('instDeriva', 150)->nullable();
            $table->text('testimonio')->nullable();

            // Problemática
            $table->json('Penal')->nullable();
            $table->json('Familiar')->nullable();
            $table->text('OtrosProblemas')->nullable();


            // Orientación interna
            $table->boolean('legal')->default(false);
            $table->boolean('social')->default(false);
            $table->boolean('psicologico')->default(false);
            $table->boolean('espiritual')->default(false);
            $table->string('institucion_a_derivar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_consulta');
    }
};
