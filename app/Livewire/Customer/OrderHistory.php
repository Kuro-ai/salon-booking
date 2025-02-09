<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderHistory extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->first();

        if ($order && $order->status === 'pending') {
            $order->update(['status' => 'canceled']);
            session()->flash('message', 'Order has been canceled.');
            $this->orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        } else {
            session()->flash('error', 'Order cannot be canceled.');
        }
    }

    public function render()
    {
        return view('livewire.customer.order-history');
    }
}
