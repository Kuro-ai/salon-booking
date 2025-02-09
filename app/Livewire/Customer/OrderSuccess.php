<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Order;

class OrderSuccess extends Component
{
    public $order;

    public function mount($orderId)
    {
        $this->order = Order::findOrFail($orderId);
    }

    public function render()
    {
        return view('livewire.customer.order-success');
    }
}

