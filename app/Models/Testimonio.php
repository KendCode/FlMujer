<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $fillable = [
        'nombre', 
        'rol', 
        'mensaje', 
        'imagen'
    ];
}
