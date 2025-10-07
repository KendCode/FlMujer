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
        Schema::create('caso_forma_violencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caso_id');
            $table->unsignedBigInteger('forma_violencias_id');
            $table->foreign('caso_id')->references('id')->on('casos')->onDelete('cascade');
            $table->foreign('forma_violencias_id')->references('id')->on('forma_violencias')->onDelete('cascade');
            $table->unique(['caso_id','forma_violencias_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caso_forma_violencia');
    }
};
