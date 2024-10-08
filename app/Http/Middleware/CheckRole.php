<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect('login');
        }

        // Vérifie si l'utilisateur possède le rôle spécifié
        if (!Auth::user()->hasRole($role)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
