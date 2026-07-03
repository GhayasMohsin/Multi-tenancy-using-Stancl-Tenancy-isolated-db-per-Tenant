<?php

use App\Http\Controllers\CentralController;
use Illuminate\Support\Facades\Route;

$centralDomain = config('tenancy.central_domains')[0];

Route::domain($centralDomain)->middleware('web')->group(function () {
    Route::get('/', [CentralController::class, 'index'])->name('central.home');
    Route::get('/register', [CentralController::class, 'create'])->name('central.register');
    Route::post('/register', [CentralController::class, 'store'])->name('central.store');
    Route::get('/tenants', [CentralController::class, 'tenants'])->name('central.tenants');
});
