<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductDetails extends Component
{
    public $product;

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
    }

    public function addToCart($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $this->product->name,
                'price' => $this->product->price,
                'image' => $this->product->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart'); // Redirect to shopping cart
    }

    public function render()
    {
        return view('livewire.customer.product-details');
    }
}
