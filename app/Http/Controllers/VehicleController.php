<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    //
    function register(Request $request) {
        $vehicle = Vehicle::updateOrCreate([
            'model' => $request->model,
            'manufacturer' => $request->manufacturer,
            'color' => $request->color,
            'capacity' => $request->capacity,
            'plate_no' => $request->plate_no,
            'recruiter_id' => Auth::user()->recruiter->id
        ]);

        if (isset($vehicle->id)) {
            return [
                'message' => 'success',
                'vehicle' => $vehicle
            ];
           } else {
            return [
                'message' => 'failed'
            ];
           }
    }


    public function getVehicles() {
        $vehicles = Vehicle::whereRecruiterId(Auth::user()->recruiter->id)->orderBy('id', 'DESC')->get();
        if ($vehicles->count()) {
            return [
                'message' => 'success',
                'vehicles' => $vehicles
            ];
        } else {
            return [
                'message' => 'failed'
            ];
        }
    }
}
