<div class="p-4">
    <h2 class="text-lg font-bold mb-4">Manage Orders</h2>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Customer</th>
                <th class="p-2 border">Total Price</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td class="p-2 border">{{ $order->id }}</td>
                <td class="p-2 border">{{ $order->user->name }}</td>
                <td class="p-2 border">${{ number_format($order->total_price, 2) }}</td>
                <td class="p-2 border">
                    <select wire:change="updateStatus({{ $order->id }}, $event.target.value)" class="border p-1">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </td>
                <td class="p-2 border">
                    <button wire:click="deleteOrder({{ $order->id }})" class="bg-red-500 text-white px-2 py-1">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
