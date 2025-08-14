<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', fn () => view('welcome'));

// /dashboard → /app (copiando só o ?tenant=...)
Route::get('/dashboard', function (Request $request) {
    $tenant = $request->query('tenant');
    $qs = $tenant ? ('?tenant=' . urlencode($tenant)) : '';
    return redirect()->to('/app' . $qs);
})->name('dashboard');

// /app → /app/crm (copiando só o ?tenant=...)
Route::get('/app', function (Request $request) {
    $tenant = $request->query('tenant');
    $qs = $tenant ? ('?tenant=' . urlencode($tenant)) : '';
    return redirect()->to('/app/crm' . $qs);
});

// Rotas do menu de perfil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Área autenticada + multi-tenant
Route::middleware(['auth', 'verified', 'resolve.tenant', 'inject.theme'])->group(function () {
    // aqui carregamos as rotas internas dos módulos:
    Route::prefix('app/crm')->name('app.crm.')->group(base_path('Modules/CRM/routes/web.php'));
    Route::prefix('app/erp')->name('app.erp.')->group(base_path('Modules/ERP/routes/web.php'));
});

require __DIR__.'/auth.php';
