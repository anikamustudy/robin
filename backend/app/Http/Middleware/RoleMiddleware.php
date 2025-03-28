<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        // Check if user's role is in the allowed roles
        if (!in_array($user->role, $roles)) {
            return response()->json(['message' => 'Unauthorized: Insufficient role permissions'], 403);
        }


        return $next($request);
    }
}
