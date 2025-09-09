<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validar credenciales básicas
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticación
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        // 🔥 CONTROL CLAVE: Verificar si el usuario está ACTIVO
        $user = Auth::user();
        
        if ($user->estado === 'inactivo') {
            // Cerrar sesión inmediatamente
            Auth::logout();
            
            // Invalidar sesión
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Mensaje de error específico
            return back()->withErrors([
                'email' => 'Tu cuenta está inactiva. Contacta con el administrador para reactivarla.',
            ])->onlyInput('email');
        }

        // Si llegó aquí, el usuario está ACTIVO ✅
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}