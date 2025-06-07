<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefreshUserData
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Refresh user data from database
            $user = Auth::user()->fresh();
            Auth::setUser($user);
        }

        return $next($request);
    }
} 