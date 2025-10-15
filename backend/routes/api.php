<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Exemple de route protégée par rôle
Route::middleware(['auth:sanctum', 'role:amc'])->group(function () {
    Route::get('/amc/dashboard', function () {
        return response()->json(['message' => 'Bienvenue AMC']);
    });
});

Route::middleware(['auth:sanctum', 'role:cms'])->group(function () {
    Route::get('/cms/dashboard', function () {
        return response()->json(['message' => 'Bienvenue CMS']);
    });
});

Route::middleware(['auth:sanctum', 'role:jury'])->group(function () {
    Route::get('/jury/dashboard', function () {
        return response()->json(['message' => 'Bienvenue Jury']);
    });
});

Route::get('/test', function () {
    return response()->json(['message' => 'API OK']);
});
