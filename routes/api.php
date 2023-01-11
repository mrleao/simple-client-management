<?php

use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Route;

//Route::get('/client/{$id}', [ClientController::class, 'index'])->name('api.client.index');
//Route::post('/client', [ClientController::class, 'store'])->name('api.client.store');

Route::apiResource('client', ClientController::class);
