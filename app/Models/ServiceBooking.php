<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $fillable = ['user_id', 'service_id', 'staff_id', 'schedule_id', 'status'];

    public function mount($id)
    {
        $this->serviceId = $id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function schedule()
    {
        return $this->belongsTo(StaffSchedule::class);
    }
}
