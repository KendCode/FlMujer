<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $fillable = [
        'seccion', 
        'titulo', 
        'descripcion', 
        'imagen'
    ];
}
