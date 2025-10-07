<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Caso;
use App\Models\FormaViolencia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CasoController extends Controller
{
    public function create()
    {
        $formas = FormaViolencia::all();
        $rangos = ['<15'=>'Menor de 15','16-20'=>'16 a 20','21-25'=>'21 a 25','26-30'=>'26 a 30','31-35'=>'31 a 35','36-40'=>'36 a 40','41-45'=>'41 a 45','46-50'=>'46 a 50','50+'=>'50 o más'];
        return view('casos.create', compact('formas','rangos'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nombres'=>'required|string|max:255',
            'apellidos'=>'required|string|max:255',
            'sexo'=>'nullable|in:M,F',
            'edad_rango'=>'nullable|string',
            'ci'=>'nullable|string|max:20',
            'id_distrito'=>'nullable|integer|min:1|max:255',
            'zona'=>'nullable|string|max:255',
            'lugar_nacimiento'=>'nullable|string|max:255',
            'reside_dentro_municipio'=>'nullable|boolean',
            'tiempo_residencia'=>'nullable|string',
            'estado_civil'=>'nullable|string',
            'nivel_instruccion'=>'nullable|string',
            'idioma'=>'nullable|string',
            'formas_violencia'=>'nullable|array',
            'formas_violencia.*'=>'integer|exists:formas_violencia,id',
            'denuncio'=>'nullable|in:0,1',
            'frecuencia_agresion'=>'nullable|string',
            'problematica'=>'nullable|string',
            'medidas_tomar_text'=>'nullable|string',
        ];

        $validated = $request->validate($rules);

        DB::transaction(function() use ($request, &$caso) {
            // crear paciente
            $paciente = Paciente::create($request->only([
                'nombres','apellidos','sexo','edad_rango','ci','id_distrito','zona','calle_numero','telefono','lugar_nacimiento','reside_dentro_municipio','tiempo_residencia','estado_civil','nivel_instruccion','idioma','ocupacion_id','situacion_ocupacional'
            ]));

            // generar nro_registro por año con "registro_counters" (evita race condition)
            $year = now()->year;
            $record = DB::table('registro_counters')->where('year', $year)->lockForUpdate()->first();

            if (!$record) {
                DB::table('registro_counters')->insert(['year'=>$year,'last_number'=>1,'created_at'=>now(),'updated_at'=>now()]);
                $num = 1;
            } else {
                DB::table('registro_counters')->where('year',$year)->update(['last_number' => DB::raw('last_number + 1')]);
                $num = DB::table('registro_counters')->where('year',$year)->value('last_number');
            }

            $consec = str_pad($num, 4, '0', STR_PAD_LEFT);
            $nro_registro = "{$year}-{$consec}";

            $caso = Caso::create([
                'nro_registro' => $nro_registro,
                'paciente_id' => $paciente->id,
                'usuario_id' => auth()->id() ?? null,
                'fecha_registro' => now(),
                'denuncio' => $request->has('denuncio') ? (bool)$request->denuncio : null,
                'frecuencia_agresion' => $request->frecuencia_agresion,
                'tipo_violencia_general' => $request->tipo_violencia_general,
                'problematica' => $request->problematica,
                'medidas_tomar_text' => $request->medidas_tomar_text,
            ]);

            if ($request->filled('formas_violencia')) {
                $caso->formasViolencia()->sync($request->formas_violencia);
            }
        });

        return redirect()->route('casos.create')->with('success', 'Caso registrado exitosamente.');
    }
}
