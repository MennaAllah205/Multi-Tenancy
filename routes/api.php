<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SetTenantDatabase;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('tenant/login', [Logincontroller::class, 'login']);

Route::post('tenant', [TenantController::class, 'store']);
    Route::apiResource('users', UserController::class);


Route::middleware([
    SetTenantDatabase::class,
         'auth:sanctum',


])->group(function () {

    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('tenant', TenantController::class)->except(['store']);

});
