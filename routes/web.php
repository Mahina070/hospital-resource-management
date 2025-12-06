<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

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
