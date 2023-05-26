<?php

namespace OneBiznet\Admin\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        // Redirect or show an error message
        return abort(403);
        // return redirect('/')->with('error', 'Unauthorized access.');
    }
}
