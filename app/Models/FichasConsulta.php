<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichasConsulta extends Model
{

    // Nombre de la tabla (si no sigue la convención plural de Laravel)
    protected $table = 'fichas_consulta';

    // Clave primaria si no es 'id'
    protected $primaryKey = 'idFicha';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'ci','nombre','apPaterno','apMaterno','numCelular',
        'fecha','instDeriva','testimonio',
        'tipo','subTipo','descripcion',
        'legal','social','psicologico','espiritual'
    ];

    // Cast para que los booleanos se manejen correctamente
    protected $casts = [
        'legal' => 'boolean',
        'social' => 'boolean',
        'psicologico' => 'boolean',
        'espiritual' => 'boolean',
        'fecha' => 'date',
    ];
}
