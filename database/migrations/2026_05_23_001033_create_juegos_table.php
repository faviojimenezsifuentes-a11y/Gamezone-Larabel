<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('juegos', function (Blueprint $table) {
            $table->id('id_juego');
            $table->string('titulo', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('categoria', 50)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->unsignedInteger('stock')->default(10);

            $table->index('categoria', 'idx_juegos_categoria');
            $table->index('titulo', 'idx_juegos_titulo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('juegos');
    }
};
