<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class ShoppingCart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = Session::get('cart', []);
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $this->cart);
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        Session::put('cart', $this->cart);
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity > 0) {
            $this->cart[$productId]['quantity'] = $quantity;
        } else {
            unset($this->cart[$productId]);
        }

        Session::put('cart', $this->cart);
    }

    public function clearCart()
    {
        $this->cart = [];
        Session::forget('cart');
    }

    public function getTotalPrice()
    {
        return array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $this->cart));
    }

    public function render()
    {
        return view('livewire.customer.shopping-cart');
    }
}

