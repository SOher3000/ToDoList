<?php
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Show the form for creating a new task
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

// Store a newly created task
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Display a listing of tasks (for Vue component)
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// Display a specific task
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
//update status
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
