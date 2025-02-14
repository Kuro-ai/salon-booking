<div class="container mx-auto p-6">
    <div class="grid grid-cols-2 gap-6">
        <!-- Product Image -->
        <div>
            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-96 object-cover">
        </div>

        <!-- Product Info -->
        <div>
            <h2 class="text-3xl font-bold">{{ $product->name }}</h2>
            <p class="text-gray-600 mt-2">{{ $product->description }}</p>
            <p class="text-2xl font-bold mt-4 text-green-600">${{ number_format($product->price, 2) }}</p>
            <p class="mt-2 {{ $product->stock > 0 ? '' : 'text-red-600 font-bold' }}">
                {{ $product->stock > 0 ? 'Stock: ' . $product->stock : 'Out of Stock' }}
            </p>            
            @if (session()->has('message'))
                <div class="bg-green-500 text-white p-2 mb-4">
                    {{ session('message') }}
                </div>
            @endif
            <!-- Add to Cart Button -->
            <button 
                wire:click="addToCart({{ $product->id }})" 
                class="mt-6 px-6 py-2 text-white {{ $product->stock > 0 ? 'bg-blue-500 hover:bg-blue-600' : 'bg-gray-400 cursor-not-allowed' }}"
                {{ $product->stock > 0 ? '' : 'disabled' }}>
                Add to Cart
            </button>
            <button wire:click="addToWishlist({{ $product->id }})" class="bg-pink-500 text-white px-4 py-2">
                ❤️ Add to Wishlist
            </button>
            
            <livewire:customer.product-reviews :product="$product" />
        </div>
    </div>
</div>
