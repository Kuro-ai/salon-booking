<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Order;

class OrderTracking extends Component
{
    public $orderId;
    public $order;

    public function searchOrder()
    {
        $this->validate(['orderId' => 'required|numeric']);

        $this->order = Order::where('id', $this->orderId)->first();

        if (!$this->order) {
            session()->flash('error', 'Order not found.');
        }
    }

    public function render()
    {
        return view('livewire.customer.order-tracking');
    }
}
