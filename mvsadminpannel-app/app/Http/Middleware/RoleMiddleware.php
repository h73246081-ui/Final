<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

     
        if ($user->id == 1) {
            return $next($request);
        }

        if ($role) {
            if (!$user->role || $user->role->name !== $role) {
                abort(403);
            }
        }

        return $next($request);
    }
}
