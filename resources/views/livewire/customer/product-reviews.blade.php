<div class="mt-6">
    <h2 class="text-xl font-bold">Customer Reviews</h2>

    @if(session()->has('message'))
        <p class="text-green-500">{{ session('message') }}</p>
    @endif

    @auth
        <div class="mt-4">
            <h3 class="text-lg font-semibold">Write a Review</h3>
            <select wire:model="rating" class="border p-2">
                <option value="">Select Rating</option>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
            <textarea wire:model="comment" class="border p-2 w-full mt-2" placeholder="Write a comment..."></textarea>
            <button wire:click="submitReview" class="bg-blue-500 text-white px-4 py-2 mt-2">Submit Review</button>
        </div>
    @else
        <p class="mt-4 text-gray-500">Please <a href="/login" class="text-blue-500">log in</a> to leave a review.</p>
    @endauth

    <div class="mt-6">
        @foreach($reviews as $review)
            <div class="border-b pb-4 mb-4">
                <p class="font-bold">{{ $review->user->name }}</p>

                @if($editingReviewId === $review->id)
                    <!-- Inline Edit Mode -->
                    <select wire:model="editRating.{{ $review->id }}" class="border p-1">
                        <option value="1">⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                    </select>
                    <textarea wire:model="editComment.{{ $review->id }}" class="border p-2 w-full mt-2"></textarea>
                    <button wire:click="updateReview({{ $review->id }})" class="bg-green-500 text-white px-4 py-1 mt-2">Save</button>
                    <button wire:click="cancelEdit" class="bg-gray-500 text-white px-4 py-1 mt-2">Cancel</button>
                @else
                    <!-- Display Mode -->
                    <p class="text-yellow-500">{{ str_repeat('⭐', $review->rating) }}</p>
                    <p class="text-gray-600">{{ $review->comment }}</p>
                    <p class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</p>

                    @if(Auth::id() === $review->user_id)
                        <div class="mt-2 flex gap-2">
                            <button wire:click="editReview({{ $review->id }})" class="text-blue-500">Edit</button>
                            <button wire:click="deleteReview({{ $review->id }})" class="text-red-500">Delete</button>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
