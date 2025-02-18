<div class="p-6 bg-white rounded-lg shadow-md max-w-4xl mx-auto mt-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Your Wishlist ❤️</h2>

    @if($wishlistItems->isEmpty())
        <p class="text-gray-500 text-center">Your wishlist is empty.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlistItems as $item)
                <div class="bg-white border rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-800">{{ $item->product->name }}</h3>
                        <p class="text-gray-600 text-sm">${{ number_format($item->product->price, 2) }}</p>
                        <div class="mt-4 space-x-3 flex justify-center">
                            <button wire:click="moveToCart({{ $item->id }})" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200">
                                Buy
                            </button>
                            <button wire:click="removeFromWishlist({{ $item->id }})" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <script>
        Livewire.on('cartUpdated', () => {
            Livewire.refresh();
        });
    </script>
</div>
