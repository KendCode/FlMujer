<?php

namespace App\Http\Controllers;

use App\Models\FichaAtencionEvaluacion;
use Illuminate\Http\Request;
use App\Models\Paciente; // Si tienes un modelo de paciente
use App\Models\Caso;

class FichaAtencionEvaluacionController extends Controller
{
    /**
     * Mostrar el formulario para crear una nueva ficha
     */
    public function create($casoId)
    {
        $caso = Caso::findOrFail($casoId);
        return view('casos.fichaAtencionEvaluacion.create', compact('caso'));
    }

    /**
     * Guardar la ficha en la base de datos
     */
    public function store(Request $request, $casoId)
    {
        $caso = Caso::findOrFail($casoId);

        // Validación
        $validated = $request->validate([
            'fecha' => 'required|date',
            'nro_registro' => 'nullable|string|max:255',
            'edad' => 'nullable|integer|min:1',
            'nombres_apellidos' => 'required|string|max:255',
            'busco_ayuda' => 'nullable|in:Si,No',
            'donde_busco_ayuda' => 'nullable|string|max:255',
            'recibio_apoyo' => 'nullable|in:Si,No',
            'donde_apoyo' => 'nullable|string|max:255',
            'concluyo_terapia' => 'nullable|in:Si,No',
            'cuando_terapia' => 'nullable|string|max:255',
            'enfermedades' => 'nullable|string',
            'motivo_consulta' => 'nullable|string',
            'descripcion_caso' => 'nullable|string',
            'pruebas_psicologicas' => 'nullable|string',
            'conducta_observable' => 'nullable|string',
            'conclusiones_valorativas' => 'nullable|string',
            'fases_intervencion' => 'nullable|string',
            'estrategia' => 'nullable|in:Individual,Pareja,Familia',
            'detalle_estrategia' => 'nullable|string',
            'fecha_proxima' => 'nullable|date',
            'remito' => 'nullable|array',
            'remito.*' => 'string|in:Legal,Trabajo Social,Espiritual,Médico',
        ]);

        // Agregar el caso_id
        $validated['caso_id'] = $caso->id;

        // Crear la ficha
        $ficha = FichaAtencionEvaluacion::create($validated);

        return redirect()
            ->route('casos.index', $caso->id)
            ->with('success', 'Ficha de atención y evaluación psicológica guardada exitosamente.');
    }

    /**
     * Mostrar una ficha específica
     */
    public function show($id)
    {
        $ficha = FichaAtencionEvaluacion::with('caso')->findOrFail($id);
        return view('casos.fichaAtencionEvaluacion.show', compact('ficha'));
    }

    /**
     * Mostrar el formulario para editar una ficha
     */
    public function edit($id)
    {
        $ficha = FichaAtencionEvaluacion::with('caso')->findOrFail($id);
        return view('casos.fichaAtencionEvaluacion.edit', compact('ficha'));
    }

    /**
     * Actualizar una ficha existente
     */
    public function update(Request $request, $id)
    {
        $ficha = FichaAtencionEvaluacion::findOrFail($id);

        // Validación
        $validated = $request->validate([
            'fecha' => 'required|date',
            'nro_registro' => 'nullable|string|max:255',
            'edad' => 'nullable|integer|min:1',
            'nombres_apellidos' => 'required|string|max:255',
            'busco_ayuda' => 'nullable|in:Si,No',
            'donde_busco_ayuda' => 'nullable|string|max:255',
            'recibio_apoyo' => 'nullable|in:Si,No',
            'donde_apoyo' => 'nullable|string|max:255',
            'concluyo_terapia' => 'nullable|in:Si,No',
            'cuando_terapia' => 'nullable|string|max:255',
            'enfermedades' => 'nullable|string',
            'motivo_consulta' => 'nullable|string',
            'descripcion_caso' => 'nullable|string',
            'pruebas_psicologicas' => 'nullable|string',
            'conducta_observable' => 'nullable|string',
            'conclusiones_valorativas' => 'nullable|string',
            'fases_intervencion' => 'nullable|string',
            'estrategia' => 'nullable|in:Individual,Pareja,Familia',
            'detalle_estrategia' => 'nullable|string',
            'fecha_proxima' => 'nullable|date',
            'remito' => 'nullable|array',
            'remito.*' => 'string|in:Legal,Trabajo Social,Espiritual,Médico',
        ]);
        
        // Actualizar la ficha
        $ficha->update($validated);

        return redirect()
            ->route('casos.show', $ficha->caso_id)
            ->with('success', 'Ficha de atención y evaluación psicológica actualizada exitosamente.');
    }

    /**
     * Eliminar una ficha
     */
    public function destroy($id)
    {
        $ficha = FichaAtencionEvaluacion::findOrFail($id);
        $casoId = $ficha->caso_id;
        $ficha->delete();

        return redirect()
            ->route('casos.show', $casoId)
            ->with('success', 'Ficha eliminada exitosamente.');
    }
}
