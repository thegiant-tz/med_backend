<?php

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/getx', function () {
    return route('recruiter.booking');
})->name('register');
Route::middleware('auth:sanctum')->post('/booking', [BookingController::class, 'book'])->name('booking');
Route::middleware('auth:sanctum')->get('/get-bookings', [BookingController::class, 'getBookings'])->name('booking');
Route::middleware('auth:sanctum')->get('/get-pending-bookings/{status}', [BookingController::class, 'getPendingBookings'])->name('pending.booking');
Route::middleware('auth:sanctum')->post('/register-vehicle', [VehicleController::class, 'register'])->name('register.vehicle');
Route::middleware('auth:sanctum')->post('/accept-request', [BookingController::class, 'acceptRequest'])->name('acceptRequest');
Route::middleware('auth:sanctum')->get('/get-vehicles', [VehicleController::class, 'getVehicles'])->name('get.vehicles');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
