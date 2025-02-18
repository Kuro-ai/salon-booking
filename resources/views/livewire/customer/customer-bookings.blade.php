<div class="container mx-auto mt-8 p-6 max-w-4xl bg-white shadow-lg rounded-lg">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">My Bookings</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-left">
                    <th class="p-4 font-medium">Service</th>
                    <th class="p-4 font-medium">Staff</th>
                    <th class="p-4 font-medium">Date & Time</th>
                    <th class="p-4 font-medium text-center">Status</th>
                    <th class="p-4 font-medium text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($bookings as $booking)
                <tr class="hover:bg-gray-100 transition">
                    <td class="p-4 border">{{ $booking->service->name }}</td>
                    <td class="p-4 border">{{ $booking->staff->name }}</td>
                    <td class="p-4 border">{{ $booking->schedule->date }} - {{ $booking->schedule->start_time }}</td>
                    <td class="p-4 border">
                        <span class="px-3 py-1 rounded-full text-white text-sm font-semibold 
                            {{ $booking->status === 'pending' ? 'bg-yellow-500' : 
                               ($booking->status === 'approved' ? 'bg-green-600' : 'bg-red-500') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="p-4 border text-center">
                        @if ($booking->status === 'pending')
                            <button @click="if(confirm('Are you sure you want to cancel this booking?')) { $wire.cancelBooking({{ $booking->id }}) }" 
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition shadow-md">
                                Cancel
                            </button>
                        @else
                            <span class="text-gray-400">Not Available</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>            
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
