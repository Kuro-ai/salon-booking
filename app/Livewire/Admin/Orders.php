<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;

class Orders extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with('user')->get();
    }

    public function updateStatus($orderId, $newStatus)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $newStatus;
        $order->save();
        $this->orders = Order::with('user')->get(); // Refresh orders
    }

    public function deleteOrder($orderId)
    {
        Order::findOrFail($orderId)->delete();
        $this->orders = Order::with('user')->get();
    }

    public function render()
    {
        return view('livewire.admin.orders');
    }
}
