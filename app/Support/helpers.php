<?php

use App\Models\Tenant;

/**
 * Retorna o tenant atual resolvido pelo middleware, ou null.
 */
function current_tenant(): ?Tenant {
    return app()->bound('currentTenant') ? app('currentTenant') : null;
}
