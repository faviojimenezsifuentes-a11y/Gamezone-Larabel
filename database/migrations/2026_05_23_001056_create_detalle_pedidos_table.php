<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_juego');
            $table->integer('cantidad')->default(1);
            $table->decimal('subtotal', 10, 2);

            $table->foreign('id_pedido')
                ->references('id_pedido')
                ->on('pedidos')
                ->onDelete('cascade');

            $table->foreign('id_juego')
                ->references('id_juego')
                ->on('juegos')
                ->restrictOnDelete();

            $table->index('id_pedido', 'idx_detalle_pedido');
            $table->index('id_juego', 'idx_detalle_juego');
            $table->unique(['id_pedido', 'id_juego'], 'uq_detalle_pedido_juego');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
