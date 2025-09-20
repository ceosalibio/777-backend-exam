<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn() => request()->user());
    Route::apiResource('employees', EmployeeController::class);
});

