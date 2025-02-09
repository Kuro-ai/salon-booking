<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Track Your Order</h2>

    <div class="mb-4">
        <input type="text" wire:model="orderId" class="border p-2 w-full" placeholder="Enter Order ID">
        @error('orderId') <span class="text-red-500">{{ $message }}</span> @enderror
        <button wire:click="searchOrder" class="bg-blue-500 text-white px-4 py-2 mt-2">Track</button>
    </div>

    @if(session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif

    @if($order)
    <div class="border p-4 mt-4">
        <h3 class="text-xl font-bold">Order Details</h3>
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Status:</strong> <span class="font-bold text-blue-500">{{ ucfirst($order->status) }}</span></p>
        <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>

        <h4 class="text-lg font-bold mt-4">Items:</h4>
        <ul>
            @foreach($order->orderItems as $item)
                <li>{{ $item->product->name }} - {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
