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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('ci', 12)->unique(); // ✅ CI único
            $table->string('name'); // ✅ Nombre
            $table->string('apellido'); // ✅ Apellido
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telefono', 20)->nullable(); // ✅ Teléfono
            $table->string('direccion')->nullable(); // ✅ Dirección
            $table->date('fecha_nacimiento')->nullable(); // ✅ Fecha nacimiento
            $table->date('fecha_ingreso')->nullable(); // ✅ Fecha ingreso
            $table->string('password');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); // ✅ Estado
            $table->enum('rol', ['administrador', 'trabajadora_social', 'abogado', 'psicologo'])
                ->default('trabajadora_social'); // ✅ Rol
            $table->string('foto')->default('fotos/default.png'); // ✅ Foto por defecto
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
