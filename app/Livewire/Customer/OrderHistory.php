<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderHistory extends Component
{
    use WithPagination;

    public $orderDetails = null;

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->first();

        if ($order && $order->status === 'pending') {
            $order->update(['status' => 'canceled']);
            session()->flash('message', 'Order has been canceled.');
        } else {
            session()->flash('error', 'Order cannot be canceled.');
        }
    }

    public function viewOrder($orderId)
    {
        $this->orderDetails = Order::with('orderItems.product')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();
    }

    public function closeOrderDetails()
    {
        $this->orderDetails = null;
    }

    public function render()
    {
        return view('livewire.customer.order-history', [
            'orders' => Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
