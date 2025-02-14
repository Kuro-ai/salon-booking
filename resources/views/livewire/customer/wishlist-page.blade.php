<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Your Wishlist ❤️</h2>

    @if($wishlistItems->isEmpty())
        <p class="text-gray-500">Your wishlist is empty.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($wishlistItems as $item)
                <div class="border p-4">
                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-40 object-cover">
                    <h3 class="font-bold">{{ $item->product->name }}</h3>
                    <p class="text-gray-600">${{ number_format($item->product->price, 2) }}</p>
                    <div class="mt-2">
                        <button wire:click="moveToCart({{ $item->id }})" class="bg-green-500 text-white px-2 py-1">Move to Cart</button>
                        <button wire:click="removeFromWishlist({{ $item->id }})" class="bg-red-500 text-white px-2 py-1">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
