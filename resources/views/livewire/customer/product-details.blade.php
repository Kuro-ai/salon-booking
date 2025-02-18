<div class="container mx-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white shadow-xl rounded-2xl p-10">
        <!-- Product Image -->
        <div class="flex justify-center">
            <img src="{{ asset('storage/' . $product->image) }}" 
                 class="w-full h-96 object-cover rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
        </div>

        <!-- Product Info -->
        <div class="flex flex-col justify-between space-y-6">
            <div>
                <h2 class="text-4xl font-bold text-gray-900">{{ $product->name }}</h2>
                <p class="text-gray-700 mt-4 text-lg leading-relaxed">{{ $product->description }}</p>
                <p class="text-3xl font-bold mt-6 text-green-500">${{ number_format($product->price, 2) }}</p>
                
                <p class="mt-4 text-lg font-semibold {{ $product->stock > 0 ? 'text-gray-800' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? 'Stock: ' . $product->stock : 'Out of Stock' }}
                </p>
                
                <!-- Success Message -->
                @if (session()->has('message'))
                    <div class="bg-green-500 text-white p-4 mt-4 rounded-lg text-center shadow-md">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex gap-4">
                <button wire:click="addToCart({{ $product->id }})"
                        class="px-6 py-3 text-lg font-semibold text-white rounded-xl shadow-md transition-all duration-300 
                               {{ $product->stock > 0 ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }}" 
                        {{ $product->stock > 0 ? '' : 'disabled' }}>
                    🛒 Add to Cart
                </button>

                <button wire:click="addToWishlist({{ $product->id }})"
                        class="px-6 py-3 text-lg font-semibold text-white rounded-xl shadow-md transition-all duration-300 
                               {{ $isInWishlist ? 'bg-gray-400 cursor-not-allowed' : 'bg-pink-500 hover:bg-pink-600' }}" 
                        {{ $isInWishlist ? 'disabled' : '' }}>
                    ❤️ {{ $isInWishlist ? 'Already in Wishlist' : 'Add to Wishlist' }}
                </button>
            </div>
        </div>
    </div>
    <!-- Customer Reviews Section -->
    <div class="mt-8 p-10 bg-white shadow-lg rounded-lg  mx-auto">
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
                        <div class="">
                            <p class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                            <p class="text-yellow-500 mt-1">{{ str_repeat('⭐', $review->rating) }}</p>
                        </div>
                        <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
    
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
    
</div>


