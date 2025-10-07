<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hijo extends Model
{
    protected $fillable = [
        'caso_id', 'edad', 'sexo',
    ];

    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }
}
