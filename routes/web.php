<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
    Route::post('/tasks/store', [TasksController::class, 'store'])->name('task.store');
    Route::get('/tasks/{task}', [TasksController::class, 'show'])->name('task.show');
    Route::get('/tasks/users', [TasksController::class, 'getUsers'])->name('tasks.users');
    Route::patch('/tasks', [TasksController::class, 'update'])->name('task.update');
    Route::delete('/tasks/{uuid}', [TasksController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__ . '/auth.php';
