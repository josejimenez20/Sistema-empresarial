<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AccountingController;

Route::get('/', [PayrollController::class, 'index']);
Route::post('/calculate', [PayrollController::class, 'store'])->name('payroll.store');
Route::get('/payroll/{id}/pdf', [PayrollController::class, 'downloadPdf'])->name('payroll.pdf');
Route::get('/contabilidad', [AccountingController::class, 'index'])->name('accounting.index');
Route::post('/contabilidad/apertura', [AccountingController::class, 'storeOpening'])->name('accounting.opening');
Route::post('/contabilidad/transaccion', [AccountingController::class, 'storeTransaction'])->name('accounting.transaction');
Route::delete('/contabilidad/transaccion/{id}', [AccountingController::class, 'destroy'])->name('accounting.destroy');