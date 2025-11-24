<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Caso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'psicologo') {
            $citas = Cita::where('usuario_id', $user->id)->get();
        } else {
            $citas = Cita::with('psicologo')->get();
        }

        return view('citas.index', compact('citas'));
    }

    public function create(Request $request)
    {
        $caso = null;

        if ($request->caso_id) {
            $caso = Caso::find($request->caso_id);
        }
        $psicologos = User::where('rol', 'psicologo')->get();

        return view('citas.create', compact('psicologos', 'caso'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'proxima_atencion' => 'required|date',
            'hora' => 'required',
            'usuario_id' => 'required|exists:users,id',
        ]);

        Cita::create($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita registrada correctamente.');
    }

    public function edit(Cita $cita)
    {
        $psicologos = User::where('rol', 'psicologo')->get();
        return view('citas.edit', compact('cita', 'psicologos'));
    }

    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'proxima_atencion' => 'required|date',
            'hora' => 'required',
            'usuario_id' => 'required|exists:users,id',
            'estado' => 'required|in:Pendiente,Confirmada,Cancelada',
        ]);

        $cita->update($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }
}
