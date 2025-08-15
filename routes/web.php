<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

# LP pública (sem tenant / sem auth)
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

# /dashboard → /app (preserva ?tenant=...)
Route::get('/dashboard', function () {
    $tenant = request('tenant');
    return redirect()->to('/app' . ($tenant ? ('?tenant=' . urlencode($tenant)) : ''));
})->name('dashboard');

# /app → /app/crm (preserva ?tenant=...)
Route::get('/app', function () {
    $tenant = request('tenant');
    return redirect()->to('/app/crm' . ($tenant ? ('?tenant=' . urlencode($tenant)) : ''));
});

# Rotas do Breeze para menu de perfil (fora do tenant)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

# Área autenticada + multi-tenant
Route::middleware(['auth','verified','resolve.tenant','inject.theme'])->group(function () {
    Route::prefix('app/crm')->name('app.crm.')->group(base_path('Modules/CRM/routes/web.php'));
    Route::prefix('app/erp')->name('app.erp.')->group(base_path('Modules/ERP/routes/web.php'));
});

require __DIR__.'/auth.php';
