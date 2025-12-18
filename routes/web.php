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

// Resource booking request page and action
Route::get('resource/book', function() {
    return view('resources.book');
})->name('resource.book.page');
Route::post('resource/book/{id}', [ResourceController::class, 'bookResource'])->name('resource.book');

// Resource booking approval page and action
Route::get('resource/approve', [ResourceController::class, 'approveBookings'])->name('resource.approve.page');
Route::post('resource/approve/{id}', [ResourceController::class, 'approveBooking'])->name('resource.approve');
Route::post('resource/reject/{id}', [ResourceController::class, 'rejectBooking'])->name('resource.reject');

// Report generation of resource bookings only administrators can access
Route::get('resource/report', [ResourceController::class, 'generateReport'])->name('resource.report');

// Dashboard route (it wil use as welcome page)
Route::get('dashboard', [ResourceController::class, 'dashboard'])->name('dashboard');

// Alert route for shortage of resource (only administrators can access and it will be triggered when resource quantity_available is below then 10)        
Route::get('resource/alerts', [ResourceController::class, 'resourceAlerts'])->name('resource.alerts');