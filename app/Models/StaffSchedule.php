<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    protected $fillable = ['staff_id', 'date', 'start_time', 'end_time', 'is_booked'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function booking()
    {
        return $this->hasOne(ServiceBooking::class, 'schedule_id');
    }
}
