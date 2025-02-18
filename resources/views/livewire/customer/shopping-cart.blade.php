<div class="container mx-auto mt-8 p-6 max-w-4xl bg-white shadow-lg rounded-lg">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">🛒 Shopping Cart</h2>

    @if(session()->has('message'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md mb-4">{{ session('message') }}</p>
    @endif

    @if(session()->has('error'))
        <p class="text-red-600 bg-red-100 p-3 rounded-md mb-4">{{ session('error') }}</p>
    @endif

    @if(empty($cart))
        <p class="text-gray-500 text-lg text-center">Your cart is empty. Start shopping now! 🛍️</p>
    @else
        <table class="w-full bg-white rounded-lg shadow-md overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <th class="p-3">Image</th>
                    <th class="p-3">Product</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Quantity</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $productId => $item)
                <tr class="border-b">
                    <td class="p-3 text-center">
                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 rounded-lg shadow-md">
                    </td>
                    <td class="p-3 text-gray-700 font-semibold">{{ $item['name'] }}</td>
                    <td class="p-3 text-gray-700 font-medium">${{ number_format($item['price'], 2) }}</td>
                    <td class="p-3 text-center">
                        <input type="number" wire:change="updateQuantity({{ $productId }}, $event.target.value)"
                            value="{{ $item['quantity'] }}" 
                            class="border p-2 w-16 rounded-md text-center shadow-sm">
                    </td>
                    <td class="p-3 text-gray-800 font-semibold">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    <td class="p-3 text-center">
                        <button wire:click="removeFromCart({{ $productId }})" 
                                class="bg-red-500 text-white px-3 py-2 rounded-md shadow-md hover:bg-red-600 transition">
                                 Remove
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            Livewire.on('cartUpdated', () => {
                Livewire.refresh();
            });
        </script>
        <!-- Coupon Section -->
        <div class="mt-6 flex items-center">
            <input type="text" wire:model="couponCode" 
                   class="border p-3 w-1/2 rounded-md shadow-sm" 
                   placeholder="Enter Coupon Code">
            <button wire:click="applyCoupon" 
                    class="bg-blue-500 text-white px-5 py-3 ml-3 rounded-md shadow-md hover:bg-blue-600 transition">
                Apply
            </button>
            @if ($appliedCoupon)
                <button wire:click="removeCoupon" 
                        class="bg-red-500 text-white px-5 py-3 ml-3 rounded-md shadow-md hover:bg-red-600 transition">
                    Remove Coupon
                </button>
            @endif
        </div>

        <!-- Discount Details -->
        @if ($appliedCoupon)
            <div class="mt-3 text-green-700 bg-green-100 p-3 rounded-md">
                Coupon Applied: <strong>{{ $appliedCoupon->code }}</strong> 
                ({{ $appliedCoupon->discount_type === 'percentage' ? $appliedCoupon->discount_value . '%' : '$' . $appliedCoupon->discount_value }})
            </div>
        @endif

        <!-- Final Price -->
        <div class="mt-6 text-right">
            <p class="text-2xl font-bold text-gray-800">Total: ${{ number_format($this->getTotalPrice(), 2) }}</p>
            @if ($appliedCoupon)
                <p class="text-2xl text-green-600 font-bold">Discounted Total: ${{ number_format($this->getFinalTotal(), 2) }}</p>
            @endif
            <div class="mt-4 space-x-3">
                <button wire:click="clearCart" 
                        class="bg-gray-500 text-white px-5 py-3 rounded-md shadow-md hover:bg-gray-600 transition">
                    🗑 Clear Cart
                </button>
                <a href="{{ route('checkout') }}" 
                   class="bg-green-500 text-white px-5 py-3 rounded-md shadow-md hover:bg-green-600 transition">
                    ✅ Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
