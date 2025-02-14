<div class="relative" x-data="{ openCart: false }">
    <!-- Cart Icon (Clickable & Hoverable) -->
    <div class="cursor-pointer relative"
         @click="openCart = !openCart"
         @mouseover="openCart = true"
         @mouseleave="openCart = false">
         
        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l1 5h13l1-5h2"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 12h14l-1 8H6l-1-8z"></path>
        </svg>

        @if ($totalItems > 0)
            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-2">
                {{ $totalItems }}
            </span>
        @endif
    </div>

    <!-- Mini Cart Dropdown -->
    <div x-show="openCart"
         @click.away="openCart = false"
         @mouseover="openCart = true"
         @mouseleave="openCart = false"
         x-transition
         class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-md p-4 z-50">
         
        <h3 class="font-bold text-lg mb-2 text-black">Cart</h3>

        @if (count($cart) > 0)
            <ul>
                @foreach($cart as $id => $item)
                    <li class="flex justify-between items-center border-b py-2">
                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-10 h-10 object-cover">
                        <div class="ml-2">
                            <p class="text-sm text-black">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">${{ number_format($item['price'], 2) }}</p>
                        </div>
                        <button wire:click="removeFromCart({{ $id }})"
                                class="text-red-500 text-sm hover:underline">
                            Remove
                        </button>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('cart') }}" class="block text-center bg-blue-500 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700">
                Go to Cart
            </a>
        @else
            <p class="text-gray-500 text-sm">Your cart is empty.</p>
        @endif
    </div>
</div>
