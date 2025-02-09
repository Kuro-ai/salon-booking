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
            <p class="mt-2">Stock: {{ $product->stock }}</p>

            <!-- Add to Cart Button -->
            <button wire:click="addToCart({{ $product->id }})" class="mt-6 bg-blue-500 text-white px-6 py-2">
                Add to Cart
            </button>
            <livewire:customer.product-reviews :product="$product" />
        </div>
    </div>
</div>
