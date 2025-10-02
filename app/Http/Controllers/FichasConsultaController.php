<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FichasConsulta;

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
            'ci' => 'required|string|unique:fichas_consulta,ci|max:9',
            'nombre' => 'required|string|max:100',
            'apPaterno' => 'required|string|max:100',
            'apMaterno' => 'nullable|string|max:100',
            'numCelular' => 'nullable|string|max:8',
            'fecha' => 'required|date',
            'tipo' => 'required|string|max:100',
            'subTipo' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        FichasConsulta::create([
            'ci' => $request->ci,
            'nombre' => $request->nombre,
            'apPaterno' => $request->apPaterno,
            'apMaterno' => $request->apMaterno,
            'numCelular' => $request->numCelular,
            'fecha' => $request->fecha,
            'instDeriva' => $request->instDeriva,
            'testimonio' => $request->testimonio,
            'tipo' => $request->tipo,
            'subTipo' => $request->subTipo,
            'descripcion' => $request->descripcion,
            'legal' => $request->has('legal'),
            'social' => $request->has('social'),
            'psicologico' => $request->has('psicologico'),
            'espiritual' => $request->has('espiritual'),
        ]);

        return redirect()->route('fichasConsulta.index')->with('success', 'Ficha creada correctamente.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
