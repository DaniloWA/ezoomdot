<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('auth.')
    ->group(base_path('routes/v1/auth.php'));

Route::middleware(['auth:sanctum'])
    ->name('tasks.')
    ->group(base_path('routes/v1/tasks.php'));
