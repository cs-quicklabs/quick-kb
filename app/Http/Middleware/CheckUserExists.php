<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckUserExists
{
    public function handle(Request $request, Closure $next)
    {
        // Check if there are any records in the users table
        $userCount = User::count();

        if ($userCount > 0) {
            // Redirect to login page if there are any users
            return redirect()->intended(route('login'))->with('error', 'The user is already created.');
        }

        return $next($request);
    }
}