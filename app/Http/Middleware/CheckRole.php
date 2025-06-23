<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }

        // Check if role is numeric or string, and convert if needed
        $userRole = Auth::user()->role;
        $requiredRole = is_numeric($role) ? (int)$role : $role;
        
        if ((is_numeric($userRole) && (int)$userRole !== $requiredRole) || 
            (!is_numeric($userRole) && $userRole !== $requiredRole)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. You do not have the required role.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        return $next($request);
    }
}
