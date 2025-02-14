<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['name', 'specialty'];

    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}
