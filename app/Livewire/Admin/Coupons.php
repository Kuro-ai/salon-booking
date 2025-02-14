<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Coupon;
use Carbon\Carbon;

class Coupons extends Component
{
    public $code, $discount_type = 'fixed', $discount_value, $minimum_order_amount, $expires_at;
    public $editingId = null;

    protected $rules = [
        'code' => 'required|unique:coupons,code',
        'discount_type' => 'required|in:fixed,percentage',
        'discount_value' => 'required|numeric|min:1',
        'minimum_order_amount' => 'nullable|numeric|min:0',
        'expires_at' => 'nullable|date|after:today',
    ];

    public function addCoupon()
    {
        $this->validate();

        Coupon::create([
            'code' => strtoupper($this->code),
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'minimum_order_amount' => $this->minimum_order_amount,
            'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at) : null,
        ]);

        $this->resetFields();
        session()->flash('message', 'Coupon added successfully!');
    }

    public function editCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->editingId = $id;
        $this->code = $coupon->code;
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->minimum_order_amount = $coupon->minimum_order_amount;
        $this->expires_at = $coupon->expires_at ? Carbon::parse($coupon->expires_at)->toDateString() : null;
    }

    public function updateCoupon()
    {
        $this->validate();

        Coupon::where('id', $this->editingId)->update([
            'code' => strtoupper($this->code),
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'minimum_order_amount' => $this->minimum_order_amount,
            'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at) : null,
        ]);

        $this->resetFields();
        session()->flash('message', 'Coupon updated successfully!');
    }

    public function deleteCoupon($id)
    {
        Coupon::destroy($id);
        session()->flash('message', 'Coupon deleted successfully!');
    }

    public function resetFields()
    {
        $this->reset(['code', 'discount_type', 'discount_value', 'minimum_order_amount', 'expires_at', 'editingId']);
    }

    public function render()
    {
        return view('livewire.admin.coupons', [
            'coupons' => Coupon::latest()->get(),
        ]);
    }
}
