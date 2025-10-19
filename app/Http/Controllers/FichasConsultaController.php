<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FichasConsulta;
use Carbon\Carbon;
class FichasConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fichas = FichasConsulta::orderBy('fecha', 'desc')->get();
        return view('fichasConsulta.index', compact('fichas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fichasConsulta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'nullable|string|unique:fichas_consulta,ci|max:9',
            'nombre' => 'required|string|max:100',
            'apPaterno' => 'required|string|max:100',
            'apMaterno' => 'nullable|string|max:100',
            'numCelular' => 'nullable|string|max:8',
            //'fecha' => 'required|date',
            'tipo' => 'nullable|string|max:100', // si luego lo agregas
            'subTipo' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        FichasConsulta::create([
            'ci' => $request->ci,
            'nombre' => $request->nombre,
            'apPaterno' => $request->apPaterno,
            'apMaterno' => $request->apMaterno,
            'numCelular' => $request->numCelular,
            'fecha' => $request->fecha ? Carbon::parse($request->fecha) : Carbon::now(),
            'instDeriva' => $request->instDeriva,
            'testimonio' => $request->testimonio,
            'Penal' => $request->has('Penal') ? $request->Penal : null,
            'Familiar' => $request->has('Familiar') ? $request->Familiar : null,
            'OtrosProblemas' => $request->OtrosProblemas,
            'legal' => $request->has('legal'),
            'social' => $request->has('social'),
            'psicologico' => $request->has('psicologico'),
            'espiritual' => $request->has('espiritual'),
            'institucion_a_derivar' => $request->institucion_a_derivar,
        ]);

        return redirect()->route('fichasConsulta.index')
            ->with('success', 'Ficha creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ficha = FichasConsulta::findOrFail($id);
        return view('fichasConsulta.edit', compact('ficha'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ficha = FichasConsulta::findOrFail($id);

        $request->validate([
            'ci' => 'nullable|string|max:9|unique:fichas_consulta,ci,' . $ficha->idFicha . ',idFicha',
            'nombre' => 'required|string|max:100',
            'apPaterno' => 'required|string|max:100',
            'apMaterno' => 'nullable|string|max:100',
            'numCelular' => 'nullable|string|max:8',
            'fecha' => 'nullable|date',
            'instDeriva' => 'nullable|string|max:150',
            'testimonio' => 'nullable|string',
            'Penal' => 'nullable|array',
            'Familiar' => 'nullable|array',
            'OtrosProblemas' => 'nullable|string',
        ]);

        $ficha->update([
            'ci' => $request->ci,
            'nombre' => $request->nombre,
            'apPaterno' => $request->apPaterno,
            'apMaterno' => $request->apMaterno,
            'numCelular' => $request->numCelular,
            'fecha' => $request->fecha,
            'instDeriva' => $request->instDeriva,
            'testimonio' => $request->testimonio,
            'Penal' => $request->Penal ?? [],
            'Familiar' => $request->Familiar ?? [],
            'OtrosProblemas' => $request->OtrosProblemas,
            'legal' => $request->has('legal'),
            'social' => $request->has('social'),
            'psicologico' => $request->has('psicologico'),
            'espiritual' => $request->has('espiritual'),
            'institucion_a_derivar' => $request->institucion_a_derivar,
        ]);

        return redirect()->route('fichasConsulta.index')->with('success', 'Ficha actualizada correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ficha = FichasConsulta::findOrFail($id);
        $ficha->delete();

        return redirect()->route('fichasConsulta.index')->with('success', 'Ficha eliminada correctamente.');
    }
}
