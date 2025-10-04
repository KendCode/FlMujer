<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonio;

class TestimonioController extends Controller
{
   public function index()
    {
        $testimonios = Testimonio::all();
        return view('admin.testimonios.index', compact('testimonios'));
    }

    public function create()
    {
        return view('admin.testimonios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'rol' => 'nullable|string|max:255',
            'mensaje' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('testimonios','public');
        }

        Testimonio::create($data);

        return redirect()->route('admin.testimonios.index')->with('success','Testimonio creado correctamente.');
    }

    public function edit(Testimonio $testimonio)
    {
        return view('admin.testimonios.edit', compact('testimonio'));
    }

    public function update(Request $request, Testimonio $testimonio)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'rol' => 'nullable|string|max:255',
            'mensaje' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('testimonios','public');
        }

        $testimonio->update($data);

        return redirect()->route('admin.testimonios.index')->with('success','Testimonio actualizado correctamente.');
    }

    public function destroy(Testimonio $testimonio)
    {
        $testimonio->delete();
        return redirect()->route('admin.testimonios.index')->with('success','Testimonio eliminado correctamente.');
    }
}
