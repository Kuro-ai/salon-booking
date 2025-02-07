<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'tracking_number', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
