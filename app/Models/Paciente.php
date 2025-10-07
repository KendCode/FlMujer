<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Caso;
use App\Models\Pareja;
use App\Models\Hijo;

class Paciente extends Model
{
    protected $fillable = ['nombres','apellidos','sexo','edad_rango','ci','id_distrito','zona','calle_numero','telefono','lugar_nacimiento','reside_dentro_municipio','tiempo_residencia','estado_civil','nivel_instruccion','idioma','ocupacion_id','situacion_ocupacional'];

    public function casos() { return $this->hasMany(Caso::class); }
    public function pareja() { return $this->hasOne(Pareja::class); }
    public function hijos() { return $this->hasMany(Hijo::class); }
}
