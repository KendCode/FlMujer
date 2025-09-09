<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Verificar rol del usuario autenticado
        $user = Auth::user();

        if ($user->rol === 'administrador') {
            // El administrador ve todos los usuarios
            $users = User::paginate(10);
            $showInactiveUsers = true; // mostramos la columna de estado
        } else {
            // Otros roles solo ven usuarios activos
            $users = User::where('estado', 'activo')->paginate(10);
            $showInactiveUsers = false; // no mostramos la columna de estado
        }

        return view('users.index', compact('users', 'showInactiveUsers'));
    }


    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|unique:users,ci',
            'name' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_ingreso' => 'nullable|date',
            'password' => 'required|min:6|confirmed',
            'rol' => 'required|in:administrador,trabajadora_social,abogado,psicologo',
            'estado' => 'required|in:activo,inactivo',
        ]);

        User::create([
            'ci' => $request->ci,
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_ingreso' => $request->fecha_ingreso,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'estado' => $request->estado,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'ci' => 'required|unique:users,ci,' . $user->id,
            'name' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_ingreso' => 'nullable|date',
            'password' => 'nullable|min:6|confirmed',
            'rol' => 'required|in:administrador,trabajadora_social,abogado,psicologo',
            'estado' => 'required|in:activo,inactivo',
        ]);
        $data = $request->only([
            'ci',
            'name',
            'apellido',
            'email',
            'telefono',
            'direccion',
            'rol',
            'estado'
        ]);

        // ✅ solo actualizamos fecha si viene en el request
        if ($request->filled('fecha_nacimiento')) {
            $data['fecha_nacimiento'] = $request->fecha_nacimiento;
        }

        if ($request->filled('fecha_ingreso')) {
            $data['fecha_ingreso'] = $request->fecha_ingreso;
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
    }
    public function toggleStatus(User $user)
    {
        // Solo administradores pueden cambiar el estado
        if (Auth::user()->rol !== 'administrador') {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $newStatus = $user->estado === 'activo' ? 'inactivo' : 'activo';
        $user->update(['estado' => $newStatus]);

        $message = $newStatus === 'activo' ? 'Usuario activado exitosamente.' : 'Usuario desactivado exitosamente.';

        return redirect()->back()->with('success', $message);
    }
}
