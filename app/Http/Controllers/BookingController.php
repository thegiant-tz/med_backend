<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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
            $booking = Booking::updateOrCreate([
                'source' => $request->source,
                'destination' => $request->destination,
                'sourceAddress' => $request->sourceAddress,
                'destinationAddress' => $request->destinationAddress,
                'recruiter_id' => Auth::user()->recruiter->id,
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

            $bookings = Booking::whereRecruiterId(Auth::user()->recruiter->id)->orderBy('id', 'DESC')->get();

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
}
