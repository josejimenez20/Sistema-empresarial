<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;

Route::get('/', [PayrollController::class, 'index']);
Route::post('/calculate', [PayrollController::class, 'store'])->name('payroll.store');
Route::get('/payroll/{id}/pdf', [PayrollController::class, 'downloadPdf'])->name('payroll.pdf');