<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class MiniCart extends Component
{
    protected $listeners = ['cartUpdated' => 'render'];

    public function removeFromCart($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        $this->dispatch('cartUpdated'); // 🔄 Notify other components
    }

    public function render()
    {
        $cart = Session::get('cart', []);
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return view('livewire.customer.mini-cart', [
            'cart' => $cart,
            'totalItems' => $totalItems,
        ]);
    }
}
