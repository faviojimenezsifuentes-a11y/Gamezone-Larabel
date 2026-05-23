<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_usuario');
            $table->string('metodo_pago', 30)->default('PayPal');
            $table->string('referencia_pago', 100)->nullable();
            $table->decimal('monto', 10, 2);
            $table->enum('estado', ['PENDIENTE', 'COMPLETADO', 'CANCELADO'])->default('COMPLETADO');
            $table->timestamp('fecha_pago')->useCurrent();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');

            $table->index('id_usuario', 'idx_pagos_usuario');
            $table->index('referencia_pago', 'idx_pagos_ref');
            $table->index('estado', 'idx_pagos_estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
