<?php

use App\Http\Controllers\Api\TugasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoint Tugas CRUD
Route::apiResource('tugas', TugasController::class);
