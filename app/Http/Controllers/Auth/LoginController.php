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
