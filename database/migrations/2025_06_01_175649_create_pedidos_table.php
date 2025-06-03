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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->string('descripcion');
            $table->string('servicio');
            $table->string('estado');
            $table->string('origen');
            $table->string('destino');

            $table->unsignedBigInteger('id_fecha');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_factura');

            $table->foreign('id_fecha')->references('id_fecha')->on('fechas')->onUpdate('cascade');
            $table->foreign('id_cliente')->references('id_cliente')->on('clientes')->onUpdate('cascade');
            $table->foreign('id_factura')->references('id_factura')->on('facturas')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
