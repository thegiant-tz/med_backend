<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    //

    public function book(Request $request)
    {

        try {
            $vehicle = Vehicle::wherePlateNo(explode(' | ', $request->vehicle)[0])->first();
            $booking = Booking::updateOrCreate([
                'source' => $request->source,
                'destination' => $request->destination,
                'sourceAddress' => $request->sourceAddress,
                'destinationAddress' => $request->destinationAddress,
                'recruiter_id' => Auth::user()->recruiter->id,
                'vehicle_id' => $vehicle->id,
                'expires_at' => (new Carbon(now(), 'Africa/Nairobi'))->addDay()->format('Y-m-d'),
            ]);

            if (isset($booking->id)) {
                return [
                    'message' => 'Data saved successfull',
                    'booking' => $booking
                ];
            } else {
                return [
                    'message' => 'Process failed'
                ];
            }
        } catch (Exception $th) {
            //throw $th;
            return $th;
        }
    }

    public function getBookings()
    {
        try {

            $bookings = Booking::with(['vehicle', 'driver'])->whereRecruiterId(Auth::user()->recruiter->id)->orderBy('id', 'DESC')->get();

            if ($bookings->count()) {
                return [
                    'message' => 'fetched',
                    'bookings' => $bookings
                ];
            } else {
                return [
                    'message' => 'Process failed',
                    'bookings' => Auth::user()->id
                ];
            }
        } catch (Exception $th) {
            //throw $th;
            return $th;
        }
    }

    function getPendingBookings(Request $request)
    {
        try {
            if(isset(Auth::user()->driver->id)) {
                $busyBookings = Booking::with(['vehicle', 'recruiter.user'])->whereDriverId(Auth::user()->driver->id)->whereStatus('Busy')->get();
            }
            if (isset(Auth::user()->driver->id) && count($busyBookings) > 0) {
                $bookings = $busyBookings;
                $status = 'Busy';
            } else {
                $status = 'Pending';
                $bookings = Booking::with(['vehicle', 'recruiter.user'])->whereStatus($request->status)->orderBy('id', 'DESC')->get();
            }

            if ($bookings->count()) {
                return [
                    'message' => 'fetched',
                    'status' => $status,
                    'bookings' => $bookings
                ];
            } else {
                return [
                    'message' => 'Process failed',
                    'bookings' => []
                ];
            }
        } catch (Exception $th) {
            //throw $th;
            return $th;
        }
    }

    function acceptRequest(Request $request)
    {
        $update = Booking::where('id', $request->id)->update([
            'driver_id' => Auth::user()->driver->id,
            'status' => 'Busy'
        ]);
        if ($update) {
            return ['message' => 'updated'];
        } else {
            return ['message' => 'not updated'];
        }
    }
}
