<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Orders</h2>

    <!-- Search Bar -->
    <input type="text" wire:model.live="search" placeholder="Search by customer name..." class="border p-2 w-full mb-4">

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Order No.</th>
                <th class="p-2 border">Customer Name</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">Address</th>
                <th class="p-2 border">Payment Method</th>
                <th class="p-2 border">Total Price</th>
                <th class="p-2 border">Discount</th>
                <th class="p-2 border">Final Price</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="hover:bg-gray-100 transition text-center">
                <td class="p-2 border">{{ $order->id }}</td> 
                <td class="p-2 border">{{ $order->name }}</td> 
                <td class="p-2 border">{{ $order->email }}</td>
                <td class="p-2 border">{{ $order->address }}</td>
                <td class="p-2 border">{{ ucfirst($order->payment_method) }}</td>
                <td class="p-2 border">${{ number_format($order->total_price, 2) }}</td>
                <td class="p-2 border">${{ number_format($order->discount, 2) }}</td> 
                <td class="p-2 border">${{ number_format($order->final_price, 2) }}</td> 
                <td class="p-2 border">
                    @if ($editingId === $order->id)
                        <select wire:model="editStatus" class="border p-1 w-full">
                            <option value="pending">Pending</option>
                            <option value="delivered">Delivered</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    @else
                        {{ ucfirst($order->status) }}
                    @endif
                </td>
                <td class="p-2 border text-center">
                    @if ($editingId === $order->id)
                        <button wire:click="saveEdit({{ $order->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                    @else
                        <button wire:click="editOrder({{ $order->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $order->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    <!-- Confirmation Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this order?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteOrder({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
