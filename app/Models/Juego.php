<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $table = 'juegos';
    protected $primaryKey = 'id_juego';
    public $timestamps = false;

    protected $fillable = [
         'titulo',
        'descripcion',
        'precio',
        'categoria',
        'imagen',
        'stock',
    ];
}
