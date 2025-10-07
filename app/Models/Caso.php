<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    protected $fillable = ['nro_registro','paciente_id','usuario_id','fecha_registro','denuncio','frecuencia_agresion','tipo_violencia_general','problematica','medidas_tomar_text'];

    public function paciente() { return $this->belongsTo(Paciente::class); }
    public function formasViolencia() { return $this->belongsToMany(FormaViolencia::class, 'caso_forma_violencia'); }

}
