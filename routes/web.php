<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
use App\Http\Controllers\UserController;
// User management routes for Manager only
Route::middleware(['auth', 'role:Manager'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


use App\Http\Controllers\ExpeditingFormController;

// Expediting form routes for Manager and Expeditor
Route::middleware(['auth', 'role:Manager,Expeditor'])->group(function () {
    Route::get('/expediting-forms/create', [ExpeditingFormController::class, 'create'])->name('expediting_forms.create');
    Route::post('/expediting-forms', [ExpeditingFormController::class, 'store'])->name('expediting_forms.store');
    Route::post('/expediting-forms/context-check', [ExpeditingFormController::class, 'checkContext'])->name('expediting_forms.context_check');
});

require __DIR__.'/auth.php';

