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
        Schema::create('fechas', function (Blueprint $table) {
            $table->id('id_fecha');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable(); // nueva mejora
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fechas');
    }
};
