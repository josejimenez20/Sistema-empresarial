<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AccountingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Route::get('/', [PayrollController::class, 'index']);
Route::post('/calculate', [PayrollController::class, 'store'])->name('payroll.store');
Route::get('/payroll/{id}/pdf', [PayrollController::class, 'downloadPdf'])->name('payroll.pdf');
Route::get('/contabilidad', [AccountingController::class, 'index'])->name('accounting.index');
Route::post('/contabilidad/apertura', [AccountingController::class, 'storeOpening'])->name('accounting.opening');
Route::post('/contabilidad/transaccion', [AccountingController::class, 'storeTransaction'])->name('accounting.transaction');
Route::delete('/contabilidad/transaccion/{id}', [AccountingController::class, 'destroy'])->name('accounting.destroy');
// RUTA TEMPORAL PARA REPARAR LA BASE DE DATOS EN PRODUCTION
Route::get('/force-setup', function () {
    try {
        // 1. Limpia cualquier caché previo
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        
        // 2. Ejecuta migraciones y seeds forzados
        Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        
        return "Sistema Restaurado: Catálogo de cuentas cargado y base de datos lista.";
    } catch (\Exception $e) {
        return "Error durante la reparación: " . $e->getMessage();
    }
});