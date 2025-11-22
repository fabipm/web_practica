<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUptEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->input('correo') ?? $request->input('email');

        if ($email) {
            $validDomains = ['@upt.pe', '@virtual.upt.pe'];
            $isValid = false;

            foreach ($validDomains as $domain) {
                if (str_ends_with($email, $domain)) {
                    $isValid = true;
                    break;
                }
            }

            if (!$isValid) {
                return back()->withErrors([
                    'correo' => 'El correo debe pertenecer al dominio @upt.pe o @virtual.upt.pe'
                ])->withInput();
            }
        }

        return $next($request);
    }
}
