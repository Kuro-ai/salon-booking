<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_type', 'discount_value', 'minimum_order_amount', 'expires_at'
    ];

    public function isExpired()
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }
}
