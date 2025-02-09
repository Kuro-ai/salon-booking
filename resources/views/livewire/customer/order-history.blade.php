<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Order History</h2>

    @if(session()->has('message'))
        <p class="text-green-500">{{ session('message') }}</p>
    @endif

    @if(session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif

    @if($orders->isEmpty())
        <p class="text-gray-500">You have no past orders.</p>
    @else
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Order ID</th>
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border">Total Price</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="p-2 border">{{ $order->id }}</td>
                    <td class="p-2 border">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="p-2 border">${{ number_format($order->total_price, 2) }}</td>
                    <td class="p-2 border">
                        <span class="font-bold text-blue-500">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="p-2 border">
                        @if($order->status === 'pending')
                            <button wire:click="cancelOrder({{ $order->id }})" class="bg-red-500 text-white px-2 py-1">Cancel</button>
                        @endif
                        <a href="{{ route('order.tracking', ['orderId' => $order->id]) }}" class="text-blue-500 ml-2">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
