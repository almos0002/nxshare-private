<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class NsfwCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Get user settings
            $settings = Settings::where('user_id', Auth::id())->first();

            // If NSFW is enabled, allow access
            if ($settings && $settings->nsfw === 'enabled') {
                return $next($request);
            }
        }

        // If not authenticated or NSFW is not enabled, redirect to home
        return redirect()->route('dashboard')->with('error', 'NSFW content is disabled. Please enable it to access this content.');
    }
}
