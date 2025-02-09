<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Shop Products</h2>

    <!-- Filters -->
    <div class="mb-6 flex space-x-4">
        <input type="text" wire:model.debounce.500ms="search" class="border p-2 w-1/3" placeholder="Search products...">
        
        <select wire:model="categoryFilter" class="border p-2">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <input type="number" wire:model="minPrice" class="border p-2 w-1/6" placeholder="Min Price">
        <input type="number" wire:model="maxPrice" class="border p-2 w-1/6" placeholder="Max Price">
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="border p-4 shadow">
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover mb-2">
                <h3 class="font-bold">{{ $product->name }}</h3>
                <p class="text-gray-500">${{ number_format($product->price, 2) }}</p>
                <a href="{{ route('product.details', $product->id) }}" class="text-blue-500">View Details</a>
                {{-- <button wire:click="addToCart({{ $product->id }})" class="mt-6 bg-blue-500 text-white px-6 py-2">
                    Add to Cart
                </button> --}}
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
