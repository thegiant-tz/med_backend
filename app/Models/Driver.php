<?php

namespace App\Models;

use App\Models\User;
use App\Models\Licence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'driver_id', 'id');
    }
    public function licence() {
        return $this->hasOne(Licence::class, 'licence_id', 'id');
    }
}
