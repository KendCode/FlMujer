<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    
    // Agrega los campos que deseas permitir actualizar masivamente
    protected $fillable = [
        'titulo',
        'descripcion',
        'orden',
        'imagen',
    ];
}


