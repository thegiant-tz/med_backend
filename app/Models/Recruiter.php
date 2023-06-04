<?php

namespace App\Models;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recruiter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vehicle() {
        return $this->hasMany(Vehicle::class, 'recruiter_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'recruiter_id', 'id');
    }
}
