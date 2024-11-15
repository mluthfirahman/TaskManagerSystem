<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// Redirect the homepage to the dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication routes for guest users
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');

    Route::post('logout', function () {
        auth()->logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    })->name('logout');

    // Define the main Task routes
    Route::resource('tasks', TaskController::class)
        ->except(['create', 'edit'])
        ->names([
            'index' => 'tasks.index',
            'store' => 'tasks.store', // This should now match `tasks.store`
            'update' => 'tasks.update',
            'destroy' => 'tasks.destroy'
        ]);

    // Routes for admin-specific actions
    Route::middleware('role:admin')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // Route for marking a task as complete (available for both admin and staff)
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    Route::middleware('auth')->group(function () {
        // Task resource routes
        Route::resource('tasks', TaskController::class);
    
        // Additional task-specific routes, if necessary
        Route::patch('tasks/{task}/complete', [TaskController::class, 'markComplete'])->name('tasks.complete');
    });

    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::patch('/tasks/{taskId}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
});
