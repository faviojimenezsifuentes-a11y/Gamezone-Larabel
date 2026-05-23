<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->unsignedBigInteger('id_usuario');
            $table->decimal('total', 10, 2);
            $table->timestamp('fecha_pedido')->useCurrent();
            $table->string('metodo_pago', 30)->default('PayPal');
            $table->string('referencia_pago', 100)->nullable();
            $table->enum('estado', ['PENDIENTE', 'COMPLETADO', 'CANCELADO'])->default('COMPLETADO');

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');

            $table->index('id_usuario', 'idx_pedidos_usuario');
            $table->index('fecha_pedido', 'idx_pedidos_fecha');
            $table->index('estado', 'idx_pedidos_estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
