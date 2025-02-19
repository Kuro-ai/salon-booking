<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'specialty', 'email', 'phone_number', 'address'];

    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}