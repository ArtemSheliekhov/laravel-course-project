<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Home
    Route::get('/', [HomeController::class, 'index']);

    // Customers
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/create', [CustomerController::class, 'create']);
    Route::post('/customers/create', [CustomerController::class, 'addToDB']);
    Route::get('/customers/edit/{id}', [CustomerController::class, 'edit']);
    Route::post('/customers/edit/{id}', [CustomerController::class, 'updateToDB']);
    Route::post('/customers/validate', [CustomerController::class, 'validateInput']);
    Route::post('/customers/delete/{id}', [CustomerController::class, 'delete']);

    // Services
    Route::get('/customerServices', [CustomerServiceController::class, 'index']);
    Route::get('/customerServices/create', [CustomerServiceController::class, 'create']);
    Route::post('/customerServices/create', [CustomerServiceController::class, 'addToDB']);
    Route::get('/customerServices/edit/{id}', [CustomerServiceController::class, 'edit']);
    Route::post('/customerServices/edit/{id}', [CustomerServiceController::class, 'updateToDB']);
    Route::post('/customerServices/validate', [CustomerController::class, 'validateInput']);
    Route::post('/customerServices/delete/{id}', [CustomerServiceController::class, 'delete']);

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/create', [AppointmentController::class, 'create']);
    Route::post('/appointments/create', [AppointmentController::class, 'addToDB']);
    Route::get('/appointments/edit/{id}', [AppointmentController::class, 'edit']);
    Route::post('/appointments/edit/{id}', [AppointmentController::class, 'updateToDB']);
    Route::get('/appointments/show/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::get('/appointments/edit/{id}', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::post('/appointments/delete/{id}', [AppointmentController::class, 'delete'])->name('appointments.delete');
    Route::get('/appointments/all', [AppointmentController::class, 'all']);

    });

require __DIR__.'/auth.php';