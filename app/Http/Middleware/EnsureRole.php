<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()->is_admin && $role == 'admin') {
            return redirect(route('user.view.dashboard'));
        }

        if ($request->user()->is_admin && $role == 'user') {
            return redirect(route('admin.view.dashboard'));
        }

        return $next($request);
    }
}
