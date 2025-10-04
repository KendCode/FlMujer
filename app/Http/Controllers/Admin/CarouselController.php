<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carousel;
class CarouselController extends Controller
{
     public function index()
    {
        $carousels = Carousel::orderBy('orden')->get();
        return view('admin.carousels.index', compact('carousels'));
    }

    public function create()
    {
        return view('admin.carousels.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'required|image|max:2048',
            'orden' => 'nullable|integer',
        ]);

        if($request->hasFile('imagen')){
            $data['imagen'] = $request->file('imagen')->store('carousels','public');
        }

        Carousel::create($data);

        return redirect()->route('admin.carousels.index')->with('success','Slide creado correctamente.');
    }

    public function edit(Carousel $carousel)
    {
        return view('admin.carousels.edit', compact('carousel'));
    }

    public function update(Request $request, Carousel $carousel)
    {
        $data = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'orden' => 'nullable|integer',
        ]);

        if($request->hasFile('imagen')){
            $data['imagen'] = $request->file('imagen')->store('carousels','public');
        }

        $carousel->update($data);

        return redirect()->route('admin.carousels.index')->with('success','Slide actualizado correctamente.');
    }

    public function destroy(Carousel $carousel)
    {
        $carousel->delete();
        return redirect()->route('admin.carousels.index')->with('success','Slide eliminado correctamente.');
    }
}
