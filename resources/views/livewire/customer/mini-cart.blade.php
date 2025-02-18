<div class="relative" x-data="{ openCart: false }">
    <!-- Cart Icon -->
    <div class="cursor-pointer relative"
         @click="openCart = !openCart"
         @mouseover="openCart = true"
         @mouseleave="openCart = false">
         
        <svg class="w-9 h-9 text-gray-800 hover:text-gray-900 transition-colors duration-300" fill="none" stroke="currentColor"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l1 5h13l1-5h2"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 12h14l-1 8H6l-1-8z"></path>
        </svg>

        @if ($totalItems > 0)
            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md">
                {{ $totalItems }}
            </span>
        @endif
    </div>
    
    <!-- Mini Cart Dropdown -->
    <div x-show="openCart"
         @click.away="openCart = false"
         @mouseover="openCart = true"
         @mouseleave="openCart = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-3 w-72 bg-white shadow-lg rounded-lg p-5 z-50 border border-gray-200">

        <h3 class="font-semibold text-lg text-gray-800 border-b pb-2">Shopping Cart</h3>

        @if (count($cart) > 0)
            <ul class="mt-3 space-y-3">
                @foreach($cart as $id => $item)
                    <li class="flex justify-between items-center bg-gray-100 p-3 rounded-md shadow-sm">
                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-12 h-12 object-cover rounded-md">
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-600">${{ number_format($item['price'], 2) }}</p>
                        </div>
                        <button wire:click="removeFromCart({{ $id }})"
                                class="text-red-500 text-xs font-medium hover:text-red-700 transition duration-200">
                            ✖
                        </button>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('cart') }}"
               class="block text-center bg-blue-600 text-white px-4 py-2 mt-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300">
                View Cart
            </a>
        @else
            <p class="text-gray-500 text-sm text-center py-3">Your cart is empty.</p>
        @endif
        
    </div>
</div>
