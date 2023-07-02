<?php

use App\Models\Vehicle;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
Route::middleware('auth:sanctum')->post('/add-reminder', function (Request $request) {
    $reminder = Reminder::updateOrCreate(
        [
            'med_name' => $request->med_name,
            'dosage' => $request->dosage,
            'unit' => $request->unit,
            'intake' => $request->intake,
            'start_at' => $request->start_at,
            'often' => $request->often,
            'description' => $request->description,
            'user_id' => Auth::user()->id
        ]
    );

    if (isset($reminder->id)) {
        return array('message' => 'success', 'data' => $reminder);
    } else {
        return array('message' => 'failed');
    }
})->name('add.reminder');

Route::middleware('auth:sanctum')->get('/get-reminders', function (Request $request) {
    $reminders = Reminder::whereUserId(Auth::user()->id)->orderBy('id', 'DESC')->get();

    if (count($reminders) > 0) {
        return array('message' => 'success', 'data' => $reminders);
    } else {
        return array('message' => 'failed');
    }
});

Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth:sanctum')->get('/get-pending-Patients', function (Request $request) {
    $reminders = Reminder::with('user')->orderBy('id', 'DESC')->get();

    if (count($reminders) > 0) {
        return array('message' => 'success', 'data' => $reminders);
    } else {
        return array('message' => 'failed');
    }
});


Route::middleware('auth:sanctum')->post('/reminder-confirmation', function (Request $request) {
    $reminders = Reminder::whereId($request->id)->update([
        'status' => 'Approved',
        'med_name' => $request->med_name,
        'intake' => $request->intake,
        'dosage' => $request->dosage,
        'often' => $request->often,
        'start_at' => $request->start_at,
        'unit' => $request->unit,
        'approved_by' => Auth::user()->id
    ]);

    if ($reminders) {
        return array('message' => 'success');
    } else {
        return array('message' => 'failed');
    }
});


Route::middleware('auth:sanctum')->post('/refill', function (Request $request) {
    $reminders = Reminder::whereId($request->id)->update(
        isset($request->med_name) ? [
            'status' => 'Pending',
            'med_name' => $request->med_name,
            'intake' => $request->intake,
            'often' => $request->often,
            'start_at' => $request->start_at,
            'unit' => $request->unit,
            'approved_by' => null,
            'dosage' => DB::raw('dosage + ' . $request->amount)
        ] : [
            'dosage' => DB::raw('dosage + ' . $request->amount),
            'status' => 'Pending'
        ]
    );

    if ($reminders) {
        return array('message' => 'success');
    } else {
        return array('message' => 'failed');
    }
});


Route::middleware('auth:sanctum')->post('/confirm-alarm', function (Request $request) {
    $reminders = Reminder::whereId($request->id)->update([
        'dosage' => DB::raw('dosage - ' . $request->intake)
    ]);

    if ($reminders) {
        return array('message' => 'success');
    } else {
        return array('message' => 'failed');
    }
});

