<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Middleware to check user ban status before proceeding with the request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Check if a user is authenticated and their status is "ban"
        if ($user && $user->status == "ban") {
            // If the user is authenticated and banned, return a 403 Forbidden error
            abort(403);
        }

        // If the user is not banned or not authenticated, continue to the next middleware or route handler
        return $next($request);
    }
}
