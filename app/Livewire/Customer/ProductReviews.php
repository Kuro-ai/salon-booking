<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProductReviews extends Component
{
    public $product;
    public $reviews;
    public $editingReviewId = null;
    public $editRating = [];
    public $editComment = [];

    public function mount()
    {
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
            session()->flash('message', 'Review updated successfully!');
            $this->reviews = $this->product->reviews()->latest()->get(); // Refresh reviews
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
            session()->flash('message', 'Review deleted successfully!');
            $this->reviews = $this->product->reviews()->latest()->get(); // Refresh reviews
        }
    }

    public function render()
    {
        return view('livewire.customer.product-reviews');
    }
}
