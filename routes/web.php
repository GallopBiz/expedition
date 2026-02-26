<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpeditingFormController;
use App\Http\Controllers\ExpeditingCardController;
use App\Http\Controllers\ExpeditingEquipmentController;

// Export all work packages with equipment
Route::get('/workpackage/export-all', [\App\Http\Controllers\ExpeditingContextController::class, 'exportAll'])->name('workpackage.export.all');

// Export Work Package with Equipment
Route::get('/workpackage/export', [\App\Http\Controllers\ExpeditingContextController::class, 'export'])->name('workpackage.export');
// One-time supplier email for equipment context
Route::post('/expediting-equipment/send-supplier-email', [ExpeditingEquipmentController::class, 'sendSupplierEmail'])->name('expediting_equipment.send_supplier_email');


// API: Get all work packages and their equipment for a context
Route::get('/api/get-work-packages-by-context', [\App\Http\Controllers\ExpeditingFormController::class, 'getWorkPackagesByContext']);



// Manager-only Expedition Form V2
Route::middleware(['auth', 'role:Manager'])->group(function () {
    Route::get('/manager/expedition-v2', [\App\Http\Controllers\SupplierExpeditionV2Controller::class, 'show'])->name('manager.expedition_v2');
    Route::post('/manager/expedition-v2/save', [\App\Http\Controllers\ExpeditingContextController::class, 'saveOrUpdate'])->name('manager.expedition_v2.save');
});

// Expeditor-only Expedition Form V2
Route::middleware(['auth', 'role:Expeditor'])->group(function () {
    Route::get('/expeditor/expedition-v2', [\App\Http\Controllers\SupplierExpeditionV2Controller::class, 'show'])->name('expeditor.expedition_v2');
});

// Supplier-only Expedition Form V2
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/expedition-v2', [\App\Http\Controllers\SupplierExpeditionV2Controller::class, 'show'])->name('supplier.expedition_v2');
    Route::post('/supplier/expedition-v2/save', [\App\Http\Controllers\ExpeditingContextController::class, 'saveOrUpdate'])->name('supplier.expedition_v2.save');
});

// Supplier-only: Work Package Cards
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/work-package-cards', [\App\Http\Controllers\ExpeditingCardController::class, 'index'])->name('supplier.work_package_cards');
});

// Notification routes
Route::middleware(['auth'])->group(function () {
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markRead'])->name('notifications.read');
});

// Work Packages List (all roles)
Route::get('/work-packages', function () {
    return view('work_packages');
})->name('work_packages');

Route::get('/', function () {
    return view('dashboard_new');
});

Route::get('/dashboard-new', function () {
    return view('dashboard_new');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

// New modern supplier expedition form (for suppliers)
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/expedition-modern', [ExpeditingFormController::class, 'supplierExpeditionModern'])->name('supplier.expedition_modern');
    Route::post('/supplier/expedition-modern', [ExpeditingFormController::class, 'supplierExpeditionModernSubmit'])->name('supplier.expedition_modern.submit');
});

// Equipment list API route
Route::get('/expediting-equipments-list', [\App\Http\Controllers\ExpeditingEquipmentController::class, 'list']);
// Equipment API routes
Route::post('/expediting-equipments', [\App\Http\Controllers\ExpeditingEquipmentController::class, 'store'])->name('expediting_equipments.store');
Route::patch('/expediting-equipments/{equipment}', [\App\Http\Controllers\ExpeditingEquipmentController::class, 'update'])->name('expediting_equipments.update');

// Language switcher route
Route::post('/language-switch', function (\Illuminate\Http\Request $request) {
    $lang = $request->input('lang', 'en');
    if (in_array($lang, ['en', 'de'])) { // Add more supported languages here
        session(['locale' => $lang]);
        app()->setLocale($lang);
    }
    return back();
})->name('language.switch');

// Restore direct dashboard view route
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'Supplier') {
        return view('supplier-dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Expediting Cards Layout (new, do not touch old list)
Route::get('/expediting-forms/cards', [ExpeditingCardController::class, 'index'])->name('expediting_forms.cards');

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

