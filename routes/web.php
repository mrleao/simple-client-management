<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Client/List');
})->name('clients.list');

Route::get('/novo-cliente', function () {
    return Inertia::render('Client/Create');
})->name('clients.create');

Route::get('/editar-cliente/{id}', function ($id) {
    return Inertia::render('Client/Edit', ['id' => $id]);
})->name('clients.edit');
