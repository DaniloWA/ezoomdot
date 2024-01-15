<?php

use App\Http\Controllers\Api\TasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Tasks Routes
|--------------------------------------------------------------------------
|
|
*/


Route::apiResource('/tasks', TasksController::class);
