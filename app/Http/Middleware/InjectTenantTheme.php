<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class InjectTenantTheme
{
    public function handle($request, \Closure $next)
    {
        /** @var \App\Models\Tenant|null $tenant */
        $tenant = app('currentTenant');

        // Evita N+1
        $tenant?->loadMissing('settings');

        $s = $tenant?->settings; // pode ser null

        \Illuminate\Support\Facades\View::share('theme', [
            'brand'     => $s?->brand_name    ?? $tenant?->name ?? 'App',
            'logo'      => $s?->logo_url      ?? null,
            'primary'   => $s?->primary_color ?? '#150259',
            'secondary' => $s?->secondary_color ?? '#F244C4',
            'email_from'=> $s?->email_from    ?? null,
            'features'  => $s?->features      ?? [],
        ]);

        return $next($request);
    }
}
