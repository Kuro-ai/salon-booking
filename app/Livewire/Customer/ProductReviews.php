<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProductReviews extends Component
{
    public $product;
    public $rating;
    public $comment;

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->reset(['rating', 'comment']);
        session()->flash('message', 'Review submitted successfully!');
    }

    public function render()
    {
        return view('livewire.customer.product-reviews', [
            'reviews' => $this->product->reviews()->latest()->get(),
        ]);
    }
}
