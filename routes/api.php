<?php

use App\Http\Controllers\ColaboradorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/colaborador", [ColaboradorController::class, "index"]);
Route::post("/colaborador", [ColaboradorController::class, "store"]);
Route::get("/colaborador/{id}", [ColaboradorController::class, "show"]);
Route::put("/colaborador/{id}", [ColaboradorController::class, "update"]);
Route::delete("/colaborador/{id}", [ColaboradorController::class, "destroy"]);
