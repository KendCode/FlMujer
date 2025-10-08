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
            $table->enum('sexo', ['M', 'F']);
            $table->string('edad_rango'); // Ej: menor15, 16a20, etc.
            $table->string('ci')->nullable();
            $table->unsignedTinyInteger('id_distrito');
            $table->string('otros')->nullable();
            $table->string('zona')->nullable();
            $table->string('calle')->nullable();
            $table->string('numero')->nullable();
            $table->string('telefono')->nullable();

            $table->string('lugar_nacimiento')->nullable();
            $table->enum('lugar_nacimiento_op', ['dentro', 'fuera'])->nullable();

            $table->enum('estado_civil', [
                'soltero',
                'conviviente',
                'viudo',
                'casado',
                'separado',
                'divorciado'
            ])->nullable();

            $table->enum('nivel_instruccion', [
                'ninguno',
                'primaria',
                'secundaria',
                'tecnico',
                'tecnicoSuperior',
                'licenciatura'
            ])->nullable();

            $table->enum('ocupacion', [
                'obrero',
                'empleada',
                'trabajadorCuentaPropia',
                'patrona',
                'socioemprendedor',
                'cooperativista',
                'aprendizSinRemuneracion',
                'aprendizConRemuneracion',
                'laboresCasa',
                'sinTrabajo',
                'otros'
            ])->nullable();

            $table->enum('situacion_ocupacional', ['permanente', 'temporal'])->nullable();

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
