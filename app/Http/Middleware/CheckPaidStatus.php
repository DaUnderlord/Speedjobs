<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPaidStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_paid) {
            // Redirect to a page explaining they need to upgrade
            // For now, redirect to dashboard with an error, or a specific upgrade page
            return redirect()->route('dashboard')->with('error', 'This feature is available for paid members only. Please upgrade your account.');
        }

        return $next($request);
    }
}
