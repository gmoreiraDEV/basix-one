<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TenantController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

// LP pública (sem tenant / sem auth)
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Redirecionamentos
|--------------------------------------------------------------------------
*/

// /dashboard → /app (preserva ?tenant=...)
Route::get('/dashboard', function () {
    $tenant = request('tenant');
    return redirect()->to('/app' . ($tenant ? ('?tenant=' . urlencode($tenant)) : ''));
})->name('dashboard');

// /app → /app/crm (preserva ?tenant=...)
Route::get('/app', function () {
    $tenant = request('tenant');
    return redirect()->to('/app/crm' . ($tenant ? ('?tenant=' . urlencode($tenant)) : ''));
});

/*
|--------------------------------------------------------------------------
| Área Admin (auth + verified)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('/tenants/{id}/restore', [TenantController::class, 'restore'])->name('tenants.restore');
    Route::get('/tenants/check-slug', [TenantController::class, 'checkSlug'])->name('tenants.check-slug');
});

/*
|--------------------------------------------------------------------------
| Perfil de Usuário (fora do tenant)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Área autenticada + multi-tenant
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'resolve.tenant', 'inject.theme'])->group(function () {
    Route::prefix('app/crm')->name('app.crm.')->group(base_path('Modules/CRM/routes/web.php'));
    Route::prefix('app/erp')->name('app.erp.')->group(base_path('Modules/ERP/routes/web.php'));
});

require __DIR__ . '/auth.php';
