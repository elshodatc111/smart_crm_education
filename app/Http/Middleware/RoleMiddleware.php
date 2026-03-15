<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware{
    public function handle(Request $request, Closure $next, ...$roles){
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('error_404');
        }
        if (!in_array($user->role, $roles)) {
            return redirect()->route('error_403');
        }
        return $next($request);
    }
}
