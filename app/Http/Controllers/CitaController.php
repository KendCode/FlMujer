<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Caso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
    public function verificarDisponibilidad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'hora' => 'required',
            'usuario_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'Datos incompletos'
            ]);
        }

        // Verificar si es día de semana (lunes a viernes)
        $fecha = Carbon::parse($request->fecha);
        $diaSemana = $fecha->dayOfWeek;

        if ($diaSemana === Carbon::SUNDAY || $diaSemana === Carbon::SATURDAY) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'Solo se pueden agendar citas de lunes a viernes'
            ]);
        }

        // Verificar si ya existe una cita en ese horario para ese psicólogo
        $citaExistente = Cita::where('usuario_id', $request->usuario_id)
            ->whereDate('proxima_atencion', $request->fecha)
            ->where('hora', $request->hora)
            ->where('estado', '!=', 'cancelada') // No contar citas canceladas
            ->first();

        if ($citaExistente) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'El psicólogo ya tiene una cita agendada en ese horario. Por favor seleccione otra hora.'
            ]);
        }

        return response()->json([
            'disponible' => true,
            'mensaje' => 'Horario disponible'
        ]);
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
        // Validar disponibilidad del psicólogo
        $existe = Cita::where('usuario_id', $request->usuario_id)
            ->where('proxima_atencion', $request->proxima_atencion)
            ->where('hora', $request->hora)
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'hora' => 'El psicólogo ya tiene una cita en esta fecha y hora.'
            ])->withInput();
        }

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
