<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
class ProductDetails extends Component
{
    public $product;

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product || $product->stock <= 0) {
            session()->flash('message', 'This product is out of stock.');
            return;
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart');
    }

    public function addToWishlist($productId)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('message', 'Please log in to add to wishlist.');
        }

        $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);

            session()->flash('message', 'Product added to wishlist!');
        }
    }

    public function render()
    {
        return view('livewire.customer.product-details');
    }
}
