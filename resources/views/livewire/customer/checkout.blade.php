<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Checkout</h2>

    <div class="mb-6">
        <h3 class="text-xl font-bold">Order Summary</h3>
        <table class="w-full border mt-2">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Product</th>
                    <th class="p-2 border">Quantity</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td class="p-2 border">{{ $item['name'] }}</td>
                    <td class="p-2 border">{{ $item['quantity'] }}</td>
                    <td class="p-2 border">${{ number_format($item['price'], 2) }}</td>
                    <td class="p-2 border">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="text-xl font-bold mt-4">Total: ${{ number_format($totalAmount, 2) }}</p>
    </div>

    <h3 class="text-xl font-bold">Shipping & Payment</h3>
    <div class="mt-4">
        <input type="text" wire:model="name" class="border p-2 w-full" placeholder="Full Name">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

        <input type="email" wire:model="email" class="border p-2 w-full mt-2" placeholder="Email">
        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

        <input type="text" wire:model="address" class="border p-2 w-full mt-2" placeholder="Shipping Address">
        @error('address') <span class="text-red-500">{{ $message }}</span> @enderror

        <select wire:model="payment_method" class="border p-2 w-full mt-2">
            <option value="">Select Payment Method</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="cash_on_delivery">Cash on Delivery</option>
        </select>
        @error('payment_method') <span class="text-red-500">{{ $message }}</span> @enderror

        <button wire:click="placeOrder" class="bg-green-500 text-white px-4 py-2 mt-4">Place Order</button>
    </div>
</div>
