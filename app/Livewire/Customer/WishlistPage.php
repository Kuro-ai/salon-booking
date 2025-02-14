<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistPage extends Component
{
    public $wishlistItems;

    public function mount()
    {
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        $this->wishlistItems = Wishlist::where('user_id', Auth::id())->with('product')->get();
    }

    public function removeFromWishlist($wishlistId)
    {
        Wishlist::find($wishlistId)?->delete();
        $this->loadWishlist(); // Refresh wishlist
    }

    public function moveToCart($wishlistId)
{
    $wishlistItem = Wishlist::find($wishlistId);

    if ($wishlistItem) {
        $cart = Session::get('cart', []);

        $productId = $wishlistItem->product_id;
        $product = $wishlistItem->product; // Load product details

        if (!$product) {
            return;
        }

        // Check if the product already exists in cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1, // Default quantity
            ];
        }

        // Update session cart
        Session::put('cart', $cart);

        // Remove from wishlist
        $wishlistItem->delete();

        // Refresh wishlist
        $this->loadWishlist();
    }
}

    public function render()
    {
        return view('livewire.customer.wishlist-page');
    }
}
