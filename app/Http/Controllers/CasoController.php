<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Caso;
use App\Models\FormaViolencia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pareja;
use App\Models\Hijo;
class CasoController extends Controller
{
    public function index()
    {
        $casos = Caso::with('pareja', 'hijos')->orderBy('created_at', 'desc')->get();
        return view('casos.index', compact('casos'));
    }
    public function create()
    {
        $formas = FormaViolencia::all();
        $rangos = ['<15'=>'Menor de 15','16-20'=>'16 a 20','21-25'=>'21 a 25','26-30'=>'26 a 30','31-35'=>'31 a 35','36-40'=>'36 a 40','41-45'=>'41 a 45','46-50'=>'46 a 50','50+'=>'50 o más'];
        return view('casos.create', compact('formas','rangos'));
    }

    public function store(Request $request)
    {
        // ✅ Validar los datos principales del formulario
        $validated = $request->validate([
            // Datos personales
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'sexo' => 'required|string|in:M,F',
            'edad_rango' => 'required|string|max:20',
            'ci' => 'nullable|string|max:20',
            'id_distrito' => 'required|integer',
            'otros' => 'nullable|string|max:100',
            'zona' => 'nullable|string|max:100',
            'calle' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'lugar_nacimiento' => 'nullable|string|max:100',

            // Datos de pareja
            'pareja_nombres' => 'nullable|string|max:100',
            'pareja_apellidos' => 'nullable|string|max:100',
            'pareja_sexo' => 'nullable|string|in:M,F',
            'pareja_edad_rango' => 'nullable|string|max:20',
            'estado_civil' => 'nullable|string|max:50',
            'ocupacion' => 'nullable|string|max:50',
            'situacion_ocupacional' => 'nullable|string|max:50',

            // Datos de hijos
            'num_hijos_gestacion' => 'nullable|string|max:50',
            'hijos_dependencia' => 'nullable|string|max:50',
            'hijos' => 'nullable|array',
        ]);

        // ✅ Crear el caso principal
        $caso = Caso::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'sexo' => $request->sexo,
            'edad_rango' => $request->edad_rango,
            'ci' => $request->ci,
            'id_distrito' => $request->id_distrito,
            'otros' => $request->otros,
            'zona' => $request->zona,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'telefono' => $request->telefono,
            'lugar_nacimiento' => $request->lugar_nacimiento,
        ]);

        // ✅ Crear los datos de pareja (si fueron enviados)
        if ($request->filled('pareja_nombres')) {
            $pareja = new Pareja([
                'nombres' => $request->pareja_nombres,
                'apellidos' => $request->pareja_apellidos,
                'sexo' => $request->pareja_sexo,
                'edad_rango' => $request->pareja_edad_rango,
                'estado_civil' => $request->estado_civil,
                'ocupacion' => $request->ocupacion,
                'situacion_ocupacional' => $request->situacion_ocupacional,
            ]);

            $caso->pareja()->save($pareja);
        }

        // ✅ Crear los datos de los hijos (si existen)
        if ($request->filled('hijos')) {
            foreach ($request->hijos as $edad => $sexos) {
                foreach ($sexos as $sexo) {
                    Hijo::create([
                        'caso_id' => $caso->id,
                        'edad' => $edad,
                        'sexo' => $sexo,
                    ]);
                }
            }
        }

        // ✅ Redirigir con mensaje
        return redirect()->route('casos.index')->with('success', 'El caso fue registrado correctamente.');
    }
}
