<?php

use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/client/search/{any}', [ClientController::class, 'getByLikeNameOrCpf'])->name('api.client.getByLikeNameOrCpf');
Route::apiResource('client', ClientController::class);
