<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Staff management routes
Route::get('staff/index', [StaffController::class, 'index'])->name('staff.index');
Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
Route::get('staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
Route::delete('staff/destroy/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

// Manage staff view (shows options to view/create/edit/delete)
Route::get('staff/manage', function () {
    return view('staffs.manage_staff');
})->name('staff.manage');