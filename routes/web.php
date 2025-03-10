<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Home Route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Appointment routes
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/{appointment}/confirmation', [AppointmentController::class, 'confirmation'])->name('appointments.confirmation');
Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.available-slots');

// Test route for email (only available in development)
if (app()->environment('local', 'development')) {
    Route::get('/test-email', [AppointmentController::class, 'sendTestEmail']);
}

// Admin routes
Route::prefix('admin')->middleware([AdminMiddleware::class])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Appointment management
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AdminController::class, 'show'])->name('appointments.show');
    Route::get('/appointments/{appointment}/edit', [AdminController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AdminController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AdminController::class, 'destroy'])->name('appointments.destroy');
    
    // Get available time slots (AJAX)
    Route::get('/available-slots', [AdminController::class, 'getAvailableSlots'])->name('appointments.available-slots');
    
    // Check for new appointments (real-time notifications)
    Route::get('/check-new-appointments', [AdminController::class, 'checkNewAppointments'])->name('check-new-appointments');
});
