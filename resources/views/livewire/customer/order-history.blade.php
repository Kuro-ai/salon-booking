<div class="container mx-auto mt-8 p-6 max-w-4xl bg-white shadow-lg rounded-xl">
    <h2 class="text-3xl font-extrabold mb-6 text-gray-800">Order History</h2>

    @if(session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 shadow-md">{{ session('message') }}</div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4 shadow-md">{{ session('error') }}</div>
    @endif

    @if($orders->isEmpty())
        <p class="text-gray-500 text-center text-lg">You have no past orders.</p>
    @else
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="w-full bg-white border-collapse rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 text-left">
                        <th class="p-4 border">Order ID</th>
                        <th class="p-4 border">Date</th>
                        <th class="p-4 border">Total Price</th>
                        <th class="p-4 border">Status</th>
                        <th class="p-4 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="p-4 border">#{{ $order->id }}</td>
                        <td class="p-4 border">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="p-4 border font-semibold text-blue-600">${{ number_format($order->total_price, 2) }}</td>
                        <td class="p-4 border">
                            <span class="px-3 py-1 rounded-full text-white text-sm font-semibold
                                {{ $order->status === 'pending' ? 'bg-yellow-500' : ($order->status === 'canceled' ? 'bg-red-500' : 'bg-green-500') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="p-4 border text-center">
                            @if($order->status === 'pending')
                                <button @click="if(confirm('Are you sure you want to cancel this order?')) { $wire.cancelOrder({{ $order->id }}) }" 
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition shadow-md">
                                    Cancel
                                </button>
                            @endif
                            <button wire:click="viewOrder({{ $order->id }})" 
                                    class="text-blue-500 font-semibold ml-3 hover:underline">View</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif

    @if($orderDetails)
    <!-- Order Details Modal -->
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full">
            <h3 class="text-2xl font-bold mb-4 text-gray-800">Order Details</h3>
            <p class="text-gray-700"><strong>Order ID:</strong> #{{ $orderDetails->id }}</p>
            <p class="text-gray-700"><strong>Status:</strong> 
                <span class="font-bold text-blue-500">{{ ucfirst($orderDetails->status) }}</span>
            </p>
            <p class="text-gray-700"><strong>Total Price:</strong> 
                <span class="text-green-600 font-semibold">${{ number_format($orderDetails->total_price, 2) }}</span>
            </p>

            <h4 class="text-lg font-bold mt-6 text-gray-800">Items:</h4>
            <ul class="mb-6 divide-y divide-gray-200">
                @foreach($orderDetails->orderItems as $item)
                    <li class="py-3 flex justify-between">
                        <span class="text-gray-700 font-semibold">{{ $item->product->name }}</span>
                        <span class="text-gray-500">{{ $item->quantity }} x ${{ number_format($item->price, 2) }}</span>
                    </li>
                @endforeach
            </ul>

            <button wire:click="closeOrderDetails" 
                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition shadow-md w-full">
                Close
            </button>
        </div>
    </div>
    @endif
</div>
