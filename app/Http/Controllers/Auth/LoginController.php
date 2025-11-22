<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@upt.pe') && !str_ends_with($value, '@virtual.upt.pe')) {
                        $fail('El correo debe pertenecer al dominio @upt.pe o @virtual.upt.pe');
                    }
                },
            ],
        ], [
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'Debe ingresar un correo válido',
        ]);

        $docente = Docente::where('correo', $request->correo)->first();

        if ($docente) {
            Session::put('docente_id', $docente->id_docente);
            Session::put('docente_data', $docente);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'correo' => 'No se encontró un docente con ese correo electrónico.',
        ])->withInput($request->only('correo'));
    }

    /**
     * Procesar el registro
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'correo' => [
                'required',
                'email',
                'unique:docentes,correo',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@upt.pe') && !str_ends_with($value, '@virtual.upt.pe')) {
                        $fail('El correo debe pertenecer al dominio @upt.pe o @virtual.upt.pe');
                    }
                },
            ],
        ], [
            'nombres.required' => 'El nombre es obligatorio',
            'apellidos.required' => 'Los apellidos son obligatorios',
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'Debe ingresar un correo válido',
            'correo.unique' => 'Este correo ya está registrado',
        ]);

        // Crear el nuevo docente (sin contraseña)
        $docente = Docente::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
        ]);

        // Iniciar sesión automáticamente
        Session::put('docente_id', $docente->id_docente);
        Session::put('docente_data', $docente);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', '¡Registro exitoso! Bienvenido al sistema.');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Session::forget('docente_id');
        Session::forget('docente_data');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
