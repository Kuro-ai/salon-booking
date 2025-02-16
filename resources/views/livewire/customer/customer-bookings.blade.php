<div>
    <h2 class="text-xl font-bold">My Bookings</h2>
    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Service</th>
                <th class="border p-2">Staff</th>
                <th class="border p-2">Date & Time</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr class="border">
                    <td class="p-2">{{ $booking->service->name }}</td>
                    <td class="p-2">{{ $booking->staff->name }}</td>
                    <td class="p-2">{{ $booking->schedule->date }} - {{ $booking->schedule->start_time }}</td>
                    <td class="p-2 text-green-600">{{ ucfirst($booking->status) }}</td>
                    <td class="p-2">
                        @if ($booking->status === 'approved')
                            <button wire:click="cancelBooking({{ $booking->id }})" 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">
                                Cancel
                            </button>
                        @else
                            <span class="text-gray-500">Booking Cancelled</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-3 mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
