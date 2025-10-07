<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaViolencia extends Model
{
    protected $table = 'forma_violencias';
    protected $fillable = ['nombre'];
    public function casos(){ return $this->belongsToMany(Caso::class,'caso_forma_violencia'); }

}
