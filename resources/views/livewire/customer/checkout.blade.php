<div class="container mx-auto mt-6 p-6 max-w-2xl bg-white shadow-lg rounded-lg">
    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Checkout</h2>

    <div class="mb-6 p-4 bg-gray-100 rounded-lg">
        <h3 class="text-xl font-semibold mb-3">Order Summary</h3>
        <table class="w-full border-collapse bg-white shadow-sm rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-3 border">Product</th>
                    <th class="p-3 border">Quantity</th>
                    <th class="p-3 border">Price</th>
                    <th class="p-3 border">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr class="text-gray-700 border-t">
                    <td class="p-3 border">{{ $item['name'] }}</td>
                    <td class="p-3 border text-center">{{ $item['quantity'] }}</td>
                    <td class="p-3 border text-center">${{ number_format($item['price'], 2) }}</td>
                    <td class="p-3 border text-center">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <p class="text-lg font-medium">Subtotal: <span class="font-semibold">${{ number_format($totalAmount, 2) }}</span></p>
            @if($discount > 0)
                <p class="text-lg text-red-500">Discount: -${{ number_format($discount, 2) }}</p>
            @endif
            <p class="text-xl font-bold mt-2">Final Total: ${{ number_format($finalTotal, 2) }}</p>
        </div>
    </div>

    <h3 class="text-xl font-semibold mb-3 text-gray-800">Shipping & Payment</h3>
    <div class="space-y-3">
        <input type="text" wire:model="name" class="border p-3 w-full rounded-md focus:ring focus:ring-green-300" placeholder="Full Name">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="email" wire:model="email" class="border p-3 w-full rounded-md focus:ring focus:ring-green-300" placeholder="Email">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="text" wire:model="address" class="border p-3 w-full rounded-md focus:ring focus:ring-green-300" placeholder="Shipping Address">
        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <select wire:model="payment_method" class="border p-3 w-full rounded-md bg-white focus:ring focus:ring-green-300">
            <option value="">Select Payment Method</option>
            <option value="visa">Visa</option>
            <option value="mpu">MPU</option>
            <option value="cash_on_delivery">Cash on Delivery</option>
        </select>
        @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <button wire:click="placeOrder" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-md transition">Place Order</button>
    </div>
</div>
