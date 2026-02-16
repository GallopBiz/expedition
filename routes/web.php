<?php
// Work Packages List (all roles)
Route::get('/work-packages', function () {
    return view('work_packages');
})->name('work_packages');

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
use App\Http\Controllers\UserController;
// User management routes for Manager and Expeditor
Route::middleware(['auth', 'role:Manager,Expeditor'])->group(function () {
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
    Route::get('/expediting-forms/list', [ExpeditingFormController::class, 'list'])->name('expediting_forms.list');
    Route::get('/expediting-forms/expediting-list', [ExpeditingFormController::class, 'expeditingList'])->name('expediting_forms.expediting_list');
    Route::post('/expediting-forms/{expeditingForm}/send-email', [ExpeditingFormController::class, 'sendEmail'])->name('expediting_forms.send_email');
    Route::get('/expediting-forms/{expeditingForm}/edit', [ExpeditingFormController::class, 'edit'])->name('expediting_forms.edit');
    Route::put('/expediting-forms/{expeditingForm}', [ExpeditingFormController::class, 'update'])->name('expediting_forms.update');
    Route::delete('/expediting-forms/{expeditingForm}', [ExpeditingFormController::class, 'destroy'])->name('expediting_forms.destroy');
});

// Restore direct dashboard view route
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'Supplier') {
        return view('supplier-dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Clean supplier routes: only inside web middleware group
Route::middleware(['web'])->group(function () {
    Route::get('/supplier/expediting-form/{expeditingForm}/access', [ExpeditingFormController::class, 'supplierAccess'])
        ->name('supplier.expedite.access')
        ->middleware(['signed']);
    Route::post('/supplier/expediting-form/{expeditingForm}/access', [ExpeditingFormController::class, 'supplierUpdate'])
        ->name('supplier.expedite.update')
        ->middleware(['signed']);
});

require __DIR__.'/auth.php';

