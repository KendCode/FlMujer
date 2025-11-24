<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
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
        // Clave única para rate limiter (por IP y email)
        $key = Str::lower($request->input('email')) . '|' . $request->ip();

        // Verificar si excedió los intentos
        if (RateLimiter::tooManyAttempts($key, 3)) { // 3 intentos
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Demasiados intentos. Intenta nuevamente en $seconds segundos."
            ])->onlyInput('email');
        }

        // Intentar autenticación
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($key, 60); // aquí se cuenta el intento
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }
        RateLimiter::clear($key); // resetear si login exitoso
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
