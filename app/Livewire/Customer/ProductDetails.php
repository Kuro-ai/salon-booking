<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Session;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class ProductDetails extends Component
{
    public $product;
    public $isInWishlist = false;
    public $reviews;
    public $rating;
    public $comment;
    public $editingReviewId = null;
    public $editRating = [];
    public $editComment = [];

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
        $this->reviews = $this->product->reviews()->latest()->get();

        if (Auth::check()) {
            $this->isInWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        }
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

        if (!$this->isInWishlist) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
            $this->isInWishlist = true;
            session()->flash('message', 'Product added to wishlist!');
        }
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'product_id' => $this->product->id,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->rating = null;
        $this->comment = null;
        $this->reviews = $this->product->reviews()->latest()->get();
    }

    public function editReview($reviewId)
    {
        $review = $this->reviews->where('id', $reviewId)->first();
        if ($review && $review->user_id === Auth::id()) {
            $this->editingReviewId = $reviewId;
            $this->editRating[$reviewId] = $review->rating;
            $this->editComment[$reviewId] = $review->comment;
        }
    }

    public function updateReview($reviewId)
    {
        $this->validate([
            "editRating.$reviewId" => 'required|integer|min:1|max:5',
            "editComment.$reviewId" => 'nullable|string|max:500',
        ]);

        $review = Review::where('id', $reviewId)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($review) {
            $review->update([
                'rating' => $this->editRating[$reviewId],
                'comment' => $this->editComment[$reviewId],
            ]);
            $this->editingReviewId = null;
            $this->reviews = $this->product->reviews()->latest()->get();
        }
    }

    public function cancelEdit()
    {
        $this->editingReviewId = null;
    }

    public function deleteReview($reviewId)
    {
        $review = Review::where('id', $reviewId)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($review) {
            $review->delete();
            $this->reviews = $this->product->reviews()->latest()->get();
        }
    }

    public function render()
    {
        return view('livewire.customer.product-details');
    }
}
