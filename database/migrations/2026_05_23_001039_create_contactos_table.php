<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacto', function (Blueprint $table) {
            $table->id('id_contacto');
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('correo', 100);
            $table->string('telefono', 20)->nullable();
            $table->text('mensaje');
            $table->timestamp('fecha_creacion')->useCurrent();

            $table->index('correo', 'idx_contacto_correo');
            $table->index('fecha_creacion', 'idx_contacto_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacto');
    }
};
