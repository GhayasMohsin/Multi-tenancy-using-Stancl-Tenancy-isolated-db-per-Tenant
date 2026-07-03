<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware(['web', InitializeTenancyBySubdomain::class, PreventAccessFromCentralDomains::class])
    ->group(function () {

        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

            Route::resource('todos', TodoController::class);
            Route::post('/todos/{id}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
        });
    });
