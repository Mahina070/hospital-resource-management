<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('staff/index', [StaffController::class, 'index'])->name('staff.index');
Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
