<div>
    <h2 class="text-xl font-bold mb-4">Manage Bookings</h2>

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-3 mb-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Customer</th>
                <th class="border p-2">Service</th>
                <th class="border p-2">Staff</th>
                <th class="border p-2">Date & Time</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr class="border">
                    <td class="p-2">{{ $booking->user->name }}</td>
                    <td class="p-2">{{ $booking->service->name }}</td>
                    <td class="p-2">{{ $booking->staff->name }}</td>
                    <td class="p-2">{{ $booking->schedule->date }} - {{ $booking->schedule->start_time }}</td>
                    <td class="p-2 {{ $booking->status === 'approved' ? 'text-green-600' : 'text-red-600' }}">
                        {{ ucfirst($booking->status) }}
                    </td>
                    <td class="p-2 space-x-2">
                        @if ($booking->status === 'pending')
                            <button wire:click="approveBooking({{ $booking->id }})" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">
                                Approve
                            </button>
                        @endif
                        @if ($booking->status !== 'cancelled')
                            <button wire:click="cancelBooking({{ $booking->id }})" 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">
                                Cancel
                            </button>
                        @endif
                        <button wire:click="deleteBooking({{ $booking->id }})" 
                                class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-700">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
