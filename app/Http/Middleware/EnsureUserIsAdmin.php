<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle($request, \Closure $next)
    {
        abort_unless(auth()->check() && auth()->user()->is_admin, 403);
        return $next($request);
    }
}
