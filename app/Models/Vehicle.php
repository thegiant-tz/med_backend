<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function recruiter() {
        return $this->belongsTo(Recruiter::class, 'user_id', 'id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'vehicle_id', 'id');
    }
}
