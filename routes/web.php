<?php

use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FileController;
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.create');
    Route::patch('/projects', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/{id}/upload', [FileController::class, 'showUploadForm'])
    ->name('projects.showUploadFormForRoot');
    Route::get('/projects/{id}/{folders?}/upload', [FileController::class, 'showUploadForm'])
    ->where('folders', '.*')
    ->name('projects.showUploadForm');
    Route::post('/projects/{id}/{folders?}/upload', [FileController::class, 'uploadFile'])
    ->where('folders', expression: '.*')
    ->name('projects.uploadFile');
    Route::get('/projects/{id}/{folders?}', [FileController::class, 'index'])
    ->where('folders', expression: '(.*)')
    ->name('projects.folder');

Route::post('/projects/{id}/folder', [FileController::class, 'createFolder'])
    ->name('projects.createFolder');
   
   
Route::post('/projects/{id}/save', [FileController::class, 'storeFile'])
->name('projects.storeFile');
  
});
Route::middleware('auth')->group(function () {
    Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations');
    Route::post('/organizations', [OrganizationController::class, 'store'])->name('organizations.create');
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
