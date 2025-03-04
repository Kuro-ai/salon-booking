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
    public $discount = 0;
    public $finalTotal = 0;
    public $name, $email, $address, $payment_method;

    public function mount()
    {
        $this->cart = Session::get('cart', []);
        $this->totalAmount = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $this->cart));

        // Retrieve applied discount from session
        $this->discount = Session::get('discount', 0);
        $this->calculateFinalTotal();

        if (empty($this->cart)) {
            return redirect()->route('livewire.customer.checkout')->with('error', 'Your cart is empty.');
        }
    }

    public function calculateFinalTotal()
    {
        $this->finalTotal = ($this->discount > 0) ? max(0, $this->totalAmount - $this->discount) : $this->totalAmount;
    }

    public function placeOrder()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'payment_method' => 'required'
        ]);

        $this->discount = Session::get('discount', 0);
        $this->calculateFinalTotal(); 

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'payment_method' => $this->payment_method,
            'total_price' => $this->totalAmount,
            'discount' => $this->discount, 
            'final_price' => $this->finalTotal,
            'status' => 'pending',
        ]);

        foreach ($this->cart as $productId => $item) {
            // Reduce stock in database
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }

            // Save order items
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Clear cart and discount session data
        Session::forget('cart'); 
        Session::forget('discount'); 
        Session::forget('applied_coupon'); 

        return redirect()->route('order.success', ['orderId' => $order->id]);
    }

    public function render()
    {
        return view('livewire.customer.checkout');
    }
}
