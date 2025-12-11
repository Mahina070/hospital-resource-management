<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ResourceController;

Route::get('/', function () {
    return view('welcome');
});

// Staff management routes
Route::get('staff/index', [StaffController::class, 'index'])->name('staff.index');
Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
Route::get('staff/show/{id}', [StaffController::class, 'show'])->name('staff.show');
Route::get('staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
Route::post('staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
Route::delete('staff/delete/{id}', [StaffController::class, 'delete'])->name('staff.delete');

// Resource management routes
Route::get('resource/index', [ResourceController::class, 'index'])->name('resource.index');
Route::get('resource/create', [ResourceController::class, 'create'])->name('resource.create');
Route::post('resource/store', [ResourceController::class, 'store'])->name('resource.store');
Route::get('resource/show/{id}', [ResourceController::class, 'show'])->name('resource.show');
Route::get('resource/edit/{id}', [ResourceController::class, 'edit'])->name('resource.edit');
Route::post('resource/update/{id}', [ResourceController::class, 'update'])->name('resource.update');
Route::delete('resource/delete/{id}', [ResourceController::class, 'delete'])->name('resource.delete');

// Search and Filter route for resources
Route::get('resource/search', [ResourceController::class, 'searchFilter'])->name('resource.search');

// Display available resources in asscending order and descending order
Route::get('resource/available/asc', [ResourceController::class, 'availableAscending'])->name('resource.available.asc');
Route::get('resource/available/desc', [ResourceController::class, 'availableDescending'])->name('resource.available.desc');
