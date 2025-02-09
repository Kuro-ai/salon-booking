<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{
    public $cart = [];
    public $totalAmount = 0;
    public $name, $email, $address, $payment_method;

    public function mount()
    {
        $this->cart = Session::get('cart', []);
        $this->totalAmount = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $this->cart));

        if (empty($this->cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }
    }

    public function placeOrder()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'payment_method' => 'required'
        ]);

        $order = Order::create([
            'user_id' => Auth::id(), // ✅ Ensure user_id is set
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'payment_method' => $this->payment_method,
            'total_price' => $this->totalAmount,
            'status' => 'pending',
        ]);

        foreach ($this->cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        Session::forget('cart'); // Clear the cart after order placement

        return redirect()->route('order.success', ['orderId' => $order->id]);
    }


    public function render()
    {
        return view('livewire.customer.checkout');
    }
}

