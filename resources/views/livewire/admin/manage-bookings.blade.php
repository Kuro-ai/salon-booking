<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Bookings</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4 flex space-x-2">
        <input type="text" wire:model.live="searchName" class="border p-2 w-1/2 rounded" placeholder="Search by customer name...">
        <input type="date" wire:model.live="searchDate" class="border p-2 w-1/2 rounded">
    </div>

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Customer</th>
                <th class="p-2 border">Service</th>
                <th class="p-2 border">Staff</th>
                <th class="p-2 border">Date & Time</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr class="hover:bg-gray-100 transition">
                    <td class="p-2 border text-center">{{ $booking->user->name }}</td>
                    <td class="p-2 border text-center">{{ $booking->service->name }}</td>
                    <td class="p-2 border text-center">{{ $booking->staff->name }}</td>
                    <td class="p-2 border text-center">{{ $booking->schedule->date }} - {{ $booking->schedule->start_time }}</td>
                    <td class="p-2 border text-center">
                        @if ($editingId === $booking->id)
                            <select wire:model="editStatus" class="border p-1 w-full">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        @else
                            <span class="px-2 py-1 rounded {{ $booking->status === 'approved' ? 'bg-green-200 text-green-700' : ($booking->status === 'cancelled' ? 'bg-red-200 text-red-700' : 'bg-yellow-200 text-yellow-700') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="p-2 border space-x-2 mx-auto">
                        @if ($editingId === $booking->id)
                            <button wire:click="saveEdit({{ $booking->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                            <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                        @else
                            <button wire:click="editBooking({{ $booking->id }}, '{{ $booking->status }}')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                            <button wire:click="confirmDelete({{ $booking->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $bookings->links() }}
    </div>

    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this booking?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteBooking({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
