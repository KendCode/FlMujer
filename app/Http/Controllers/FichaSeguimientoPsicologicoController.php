<?php

namespace App\Http\Controllers;

use App\Models\FichaSeguimientoPsicologico;
use App\Models\Caso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class FichaSeguimientoPsicologicoController extends Controller
{
    public function index($casoId)
    {
        $caso = Caso::findOrFail($casoId); // Traemos el caso completo
        $fichas = FichaSeguimientoPsicologico::where('caso_id', $casoId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('casos.fichaSeguimientoPsicologico.index', compact('caso', 'fichas'));
    }


    public function create($caso_id)
    {
        $caso = Caso::findOrFail($caso_id);  // Para seleccionar caso
        return view('casos.fichaSeguimientoPsicologico.create', compact('caso'));
    }

    public function store(Request $request, $caso_id)
    {
        $caso = Caso::findOrFail($caso_id);
        // 🔹 Obtener el último número de sesión registrado para este caso
        $ultimoNumero = FichaSeguimientoPsicologico::where('caso_id', $caso_id)
            ->max('nro_sesion');

        // 🔹 Calcular el siguiente número de sesión
        $siguienteNumero = $ultimoNumero ? $ultimoNumero + 1 : 1;

        // 🔹 Validación general (ya no pedimos nro_sesion al usuario)
        $request->validate([
            'fecha' => 'required|date',
            'estrategia' => 'required|string',
            'antecedentes' => 'nullable|string',
            'conducta_observable' => 'nullable|string',
            'conclusiones_valorativas' => 'nullable|string',
            'estrategias_intervencion' => 'nullable|string',
            'fecha_proxima_atencion' => 'nullable|date',
            'nombre_psicologo' => 'nullable|string|max:255',
        ]);

        // 🔹 Crear la ficha con el número de sesión autogenerado
        FichaSeguimientoPsicologico::create([
            'caso_id' => $caso_id,
            'nro_registro' => $caso->nro_registro,
             'nombre_apellidos' => $caso->paciente_nombres . ' ' . $caso->paciente_apellidos, // ✅ se llena automáticamente
            'fecha' => $request->fecha,
            'nro_sesion' => $siguienteNumero,
            'estrategia' => $request->estrategia,
            'antecedentes' => $request->antecedentes,
            'conducta_observable' => $request->conducta_observable,
            'conclusiones_valorativas' => $request->conclusiones_valorativas,
            'estrategias_intervencion' => $request->estrategias_intervencion,
            'fecha_proxima_atencion' => $request->fecha_proxima_atencion,
            'nombre_psicologo' => $request->nombre_psicologo,
        ]);

        return redirect()->route('casos.fichaSeguimientoPsicologico.index', $caso_id)
            ->with('success', 'Ficha de seguimiento creada correctamente. Número de sesión: ' . $siguienteNumero);
    }


    public function show(FichaSeguimientoPsicologico $fichaSeguimientoPsicologico)
    {
        return view('casos.fichaSeguimientoPsicologico.show', compact('fichaSeguimientoPsicologico'));
    }

    public function edit($casoId, $fichaId)
    {
        $caso = Caso::findOrFail($casoId);
        $ficha = FichaSeguimientoPsicologico::findOrFail($fichaId);

        return view('casos.fichaSeguimientoPsicologico.edit', compact('caso', 'ficha'));
    }


    public function update(Request $request, $casoId, $fichaId)
    {
        $ficha = FichaSeguimientoPsicologico::findOrFail($fichaId);

        $validated = $request->validate([
            'fecha' => 'required|date',
            'nro_sesion' => 'required|integer|min:1',
            'estrategia' => 'nullable|in:Individual,Pareja,Familia',
            'nombre_psicologo' => 'required|string|max:255',
            'antecedentes' => 'nullable|string',
            'conducta_observable' => 'nullable|string',
            'conclusiones_valorativas' => 'nullable|string',
            'estrategias_intervencion' => 'nullable|string',
            'fecha_proxima_atencion' => 'nullable|date',
        ]);

        // Mantener campos que no vienen del formulario
        $validated['caso_id'] = $casoId;
        $validated['nro_registro'] = $ficha->nro_registro ?? '';
        $validated['nombre_apellidos'] = $ficha->nombre_apellidos ?? '';

        $ficha->update($validated);

        return redirect()->route('casos.fichaSeguimientoPsicologico.index', $casoId)
            ->with('success', 'Ficha actualizada correctamente.');
    }



    public function destroy($casoId, $fichaId)
    {
        $ficha = FichaSeguimientoPsicologico::findOrFail($fichaId);
        $ficha->delete();

        return redirect()->route('casos.fichaSeguimientoPsicologico.index', $casoId)
            ->with('success', 'Ficha eliminada correctamente.');
    }
}
