<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actividad;

class ActividadController extends Controller
{
    public function index()
    {
        $actividades = Actividad::all();
        return view('admin.actividades.index', compact('actividades'));
    }

    public function create()
    {
        return view('admin.actividades.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('actividades','public');
        }

        Actividad::create($data);

        return redirect()->route('admin.actividades.index')->with('success','Actividad creada correctamente.');
    }

    public function edit(Actividad $actividad)
    {
        return view('admin.actividades.edit', compact('actividad'));
    }

    public function update(Request $request, Actividad $actividad)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('actividades','public');
        }

        $actividad->update($data);

        return redirect()->route('admin.actividades.index')->with('success','Actividad actualizada correctamente.');
    }

    public function destroy(Actividad $actividad)
    {
        $actividad->delete();
        return redirect()->route('admin.actividades.index')->with('success','Actividad eliminada correctamente.');
    }
}
