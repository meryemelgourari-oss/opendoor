<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Connecté ET admin → accès autorisé
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Connecté mais pas admin → 403 Forbidden
        if (Auth::check()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        // Non connecté → redirection login
        return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cet espace.');
    }
}