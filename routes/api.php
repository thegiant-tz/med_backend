<?php

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VehicleController;
use App\Models\Reminder;

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
// Route::group(['middleware' => ['auth:sanctum']], function () {
Route::post('/add-reminder', function (Request $request) {
    $reminder = Reminder::updateOrCreate(
        [
            'med_name' => $request->med_name,
            'dosage' => $request->dosage,
            'unit' => $request->unit,
            'intake' => $request->intake,
            'start_at' => $request->start_at,
            'often' => $request->often
        ]
    );

    if (isset($reminder->id)) {
        return array('message' => 'success', 'data' => $reminder);
    } else {
        return array('message' => 'failed');
    }
})->name('add.reminder');

Route::get('/get-reminders', function (Request $request) {
    $reminders = Reminder::orderBy('id', 'DESC')->get();

    if (count($reminders) > 0) {
        return array('message' => 'success', 'data' => $reminders);
    } else {
        return array('message' => 'failed');
    }
})->name('get.reminders');
// });
// Route::middleware('auth:sanctum')->post('/booking', [BookingController::class, 'book'])->name('booking');
// Route::middleware('auth:sanctum')->get('/get-bookings', [BookingController::class, 'getBookings'])->name('booking');
// Route::middleware('auth:sanctum')->post('/register-vehicle', [VehicleController::class, 'register'])->name('register.vehicle');
// Route::middleware('auth:sanctum')->get('/get-vehicles', [VehicleController::class, 'getVehicles'])->name('get.vehicles');
