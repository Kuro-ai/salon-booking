<div class="mt-8 p-6 bg-white shadow-lg rounded-lg max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Customer Reviews</h2>

    @if(session()->has('message'))
        <p class="text-green-500 mt-2 text-sm">{{ session('message') }}</p>
    @endif

    @auth
        <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800">Write a Review</h3>
            <div class="mt-2 space-y-4">
                <select wire:model="rating"  class="border p-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="">Select Rating</option>
                    <option value="1">⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                </select>
                <textarea wire:model="comment" class="border p-3 w-full rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write a comment..." rows="4"></textarea>
            </div>
            <button wire:click="submitReview" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-all">Submit Review</button>
        </div>
    @else
        <p class="mt-4 text-gray-500">Please <a href="/login" class="text-blue-500 hover:underline">log in</a> to leave a review.</p>
    @endauth

    <div class="mt-8 space-y-6">
        @foreach($reviews as $review)
            <div class="bg-gray-50 p-4 rounded-lg shadow-lg border-b">
                <p class="font-semibold text-gray-800">{{ $review->user->name }}</p>

                @if($editingReviewId === $review->id)
                    <!-- Inline Edit Mode -->
                    <div class="mt-2 space-y-4">
                        <select wire:model="editRating.{{ $review->id }}" class="border p-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="1">⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select>
                        <textarea wire:model="editComment.{{ $review->id }}" class="border p-3 w-full rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
                    </div>                    
                    <div class="mt-4 flex gap-6">
                        <button wire:click="updateReview({{ $review->id }})" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition-all">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-all">Cancel</button>
                    </div>
                @else
                    <!-- Display Mode -->
                    <div class="mt-2">
                        <p class="text-yellow-500">{{ str_repeat('⭐', $review->rating) }}</p>
                    </div>
                    <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
                    <p class="text-sm text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>

                    @if(Auth::id() === $review->user_id)
                        <div class="mt-4 flex gap-4">
                            <button wire:click="editReview({{ $review->id }})" class="text-blue-500 hover:underline">Edit</button>
                            <button wire:click="deleteReview({{ $review->id }})" class="text-red-500 hover:underline">Delete</button>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
