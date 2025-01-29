<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BreweryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);

Route::get('/breweries', [BreweryController::class, 'index'])
    ->middleware('auth:sanctum');

