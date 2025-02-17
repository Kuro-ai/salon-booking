<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Coupon;
use Carbon\Carbon;

class Coupons extends Component
{
    public $code, $discount_type = 'fixed', $discount_value, $minimum_order_amount, $expires_at;
    public $coupons;
    public $editingId = null;
    public $confirmingDelete = null;
    public $search = '';


    public function mount()
    {
        $this->loadCoupons();
    }

    public function loadCoupons()
    {
        $this->coupons = Coupon::whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function addCoupon()
    {
        $this->validate([
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:1',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after:today',
        ]);

        Coupon::create([
            'code' => strtoupper($this->code),
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'minimum_order_amount' => $this->minimum_order_amount,
            'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at) : null,
        ]);

        session()->flash('message', 'Coupon added successfully!');
        $this->resetFields();
        $this->loadCoupons();
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
        Coupon::where('id', $this->editingId)->update([
            'code' => strtoupper($this->code),
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'minimum_order_amount' => $this->minimum_order_amount,
            'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at) : null,
        ]);

        session()->flash('message', 'Coupon updated successfully!');
        $this->resetFields();
        $this->loadCoupons();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function deleteCoupon($id)
    {
        Coupon::destroy($id);
        session()->flash('message', 'Coupon deleted successfully!');
        $this->confirmingDelete = null;
        $this->loadCoupons();
    }

    public function resetFields()
    {
        $this->reset(['code', 'discount_type', 'discount_value', 'minimum_order_amount', 'expires_at', 'editingId']);
    }

    public function render()
    {
        $this->loadCoupons();
        return view('livewire.admin.coupons');
    }
}
