<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>

    @if(empty($cart))
        <p class="text-gray-600">Your cart is empty.</p>
    @else
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Image</th>
                    <th class="p-2 border">Product</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Quantity</th>
                    <th class="p-2 border">Total</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $productId => $item)
                <tr>
                    <td class="p-2 border">
                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16">
                    </td>
                    <td class="p-2 border">{{ $item['name'] }}</td>
                    <td class="p-2 border">${{ number_format($item['price'], 2) }}</td>
                    <td class="p-2 border">
                        <input type="number" wire:change="updateQuantity({{ $productId }}, $event.target.value)"
                            value="{{ $item['quantity'] }}" class="border p-1 w-16">
                    </td>
                    <td class="p-2 border">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    <td class="p-2 border">
                        <button wire:click="removeFromCart({{ $productId }})" class="bg-red-500 text-white px-2 py-1">
                            Remove
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <p class="text-xl font-bold">Total: ${{ number_format($this->getTotalPrice(), 2) }}</p>
            <button wire:click="clearCart" class="bg-gray-500 text-white px-4 py-2 mt-2">Clear Cart</button>
            <a href="{{ route('checkout') }}" class="bg-green-500 text-white px-4 py-2 mt-2">Proceed to Checkout</a>
        </div>
    @endif
</div>
