<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;

class ResolveTenant
{
    /**
     * Estratégia de resolução (ordem):
     * 1) Query string ?tenant=slug  (dev e links internos)
     * 2) Header X-Tenant: slug      (útil p/ API / front separada)
     * 3) Domínio exato              (produção com domínio próprio por tenant)
     * 4) Subdomínio (acme.dominio.com)
     * 5) Fallback em ambiente local (slug 'demo')
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant = null;
        $host   = $request->getHost();

        // helper de sanitização (aceita letras, números, -, _, .)
        $sanitize = fn (?string $v) => $v ? preg_replace('/[^a-z0-9\-_.]/i', '', $v) : null;

        // 1) ?tenant=slug
        if (!$tenant) {
            $slug = $sanitize($request->query('tenant'));
            if ($slug) {
                $tenant = Tenant::where('slug', $slug)->first();
            }
        }

        // 2) Header X-Tenant: slug (opcional; útil para API/SPA)
        if (!$tenant) {
            $slug = $sanitize($request->header('X-Tenant'));
            if ($slug) {
                $tenant = Tenant::where('slug', $slug)->first();
            }
        }

        // 3) domínio exato
        if (!$tenant) {
            $tenant = Tenant::where('domain', $host)->first();
        }

        // 4) subdomínio (acme.seu-dominio.com)
        if (!$tenant && str_contains($host, '.')) {
            $parts = explode('.', $host);
            $sub   = $parts[0] ?? null; // evita "Undefined array key 0"
            $sub   = $sanitize($sub);
            if ($sub) {
                $tenant = Tenant::where('slug', $sub)->first();
            }
        }

        // 5) fallback em desenvolvimento (opcional)
        if (!$tenant && app()->environment('local')) {
            $tenant = Tenant::where('slug', 'demo')->first();
        }

        // se ainda não achou, 404
        abort_if(!$tenant, 404, 'Tenant not found. Use ?tenant=demo em DEV.');

        // disponibiliza o tenant no container da aplicação
        app()->instance('currentTenant', $tenant);

        // (opcional) você pode definir um escopo global aqui, caso queira
        // Model::addGlobalScope(new TenantScope($tenant->id));

        return $next($request);
    }
}
