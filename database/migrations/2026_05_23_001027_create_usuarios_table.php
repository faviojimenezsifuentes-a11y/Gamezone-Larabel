<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('correo', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('password', 255);
            $table->timestamp('fecha_registro')->useCurrent();

            $table->index('correo', 'idx_usuarios_correo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
