<?php

namespace App\Models;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Licence extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function driver() {
        return $this->belongsTo(Driver::class, 'licence_id', 'id');
    }
}
