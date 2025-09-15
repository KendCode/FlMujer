<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLES = [
        'administrador',
        'trabajadora_social',
        'abogado',
        'psicologo',
    ];

    public const ESTADOS = [
        'activo',
        'inactivo',
    ];

    protected $fillable = [
        'ci',
        'name',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'fecha_ingreso',
        'password',
        'estado',
        'rol',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
    ];
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
    
        // Foto por defecto
        return asset('storage/fotos/default.png');
    }
}
