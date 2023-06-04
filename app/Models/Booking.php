<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Recruiter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function recruiter() {
        return $this->belongsTo(Recruiter::class, 'recruiter_id', 'id');
    }

    public function driver() {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
