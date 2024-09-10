<?php

use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\OrganizationController;
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/projects', function () {
    return Inertia::render('Projects');
})->middleware(['auth', 'verified'])->name('projects');
Route::middleware('auth')->group(function () {
    Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations');
    Route::post('/organizations', [OrganizationController::class, 'store'])->name('admin.store');
    Route::get('/organizations/{id}/users', [OrganizationController::class, 'showUsers'])->name('organizations.users');
    Route::get('organizations/{id}/users/create', [InvitationsController::class, 'index'])->name('organizations.createUsers');
    Route::post('organizations/{id}/users/create', [InvitationsController::class, 'store'])->name('organizations.inviteUser');
  
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
