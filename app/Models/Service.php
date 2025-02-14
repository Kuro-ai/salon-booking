<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceBooking;

class Service extends Model
{
    protected $fillable = ['name', 'price', 'description'];

    public function bookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}
