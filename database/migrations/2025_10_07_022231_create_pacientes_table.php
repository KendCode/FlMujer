<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('sexo', ['M','F'])->nullable();
            $table->string('edad_rango')->nullable(); // ej: "16-20"
            $table->string('ci')->nullable()->unique();
            $table->unsignedTinyInteger('id_distrito')->nullable();
            $table->string('zona')->nullable();
            $table->string('calle_numero')->nullable();
            $table->string('telefono')->nullable();
            $table->string('lugar_nacimiento')->nullable();
            $table->boolean('reside_dentro_municipio')->default(true);
            $table->string('tiempo_residencia')->nullable(); // "menos de 1 año", "2-5"...
            $table->string('estado_civil')->nullable();
            $table->string('nivel_instruccion')->nullable();
            $table->string('idioma')->nullable();
            $table->unsignedBigInteger('ocupacion_id')->nullable();
            $table->string('situacion_ocupacional')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
