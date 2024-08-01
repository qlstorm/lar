<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParametersController;

Route::get('/', [ParametersController::class, 'list']);
Route::get('/json', [ParametersController::class, 'json']);
Route::any('/{id}', [ParametersController::class, 'show']);
