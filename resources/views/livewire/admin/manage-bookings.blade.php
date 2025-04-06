<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Bookings</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4 flex space-x-3">
        <input type="text" wire:model.live="searchName" class="border p-2 w-1/3 rounded" placeholder="Search by customer/staff name...">
        <input type="date" wire:model.live="searchDate" class="border p-2 w-1/3 rounded">
        <select wire:model.live="statusFilter" class="border p-2 w-1/3 rounded">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="cancelled">Cancelled</option>
        </select>
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
            <tr class="bg-blue-50">
                <td class="p-2 border">
                    <input type="text" wire:model="newCustomerName" class="border p-1 w-full rounded" placeholder="Customer Name">
                </td>
                <td class="p-2 border">
                    <select wire:model="newServiceId" class="border p-1 w-full rounded">
                        <option value="">Select Service</option>
                        @foreach(\App\Models\Service::all() as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-2 border">
                    <select wire:model="newStaffId" class="border p-1 w-full rounded">
                        <option value="">Select Staff</option>
                        @foreach(\App\Models\Staff::all() as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-2 border">
                    <select wire:model="newScheduleId" class="border p-1 w-full rounded">
                        <option value="">Select Schedule</option>
                        @foreach(\App\Models\StaffSchedule::where('is_booked', false)->get() as $schedule)
                            <option value="{{ $schedule->id }}">{{ $schedule->date }} - {{ $schedule->start_time }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-2 border">
                    <select wire:model="newStatus" class="border p-1 w-full rounded">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </td>
                <td class="p-2 border">
                    <button wire:click="addBooking" class="bg-green-500 text-white px-2 py-1 rounded">Add Booking</button>
                </td>
            </tr>
            
            
            @foreach($bookings as $booking)
                <tr class="hover:bg-gray-100 transition">
                    <td class="p-2 border text-center">
                        @if ($editingId === $booking->id)
                            <input type="text" wire:model.defer="editCustomerName" class="border p-1 w-full rounded" />
                        @else
                            {{ $booking->user->name }}
                        @endif
                    </td>
                    <td class="p-2 border text-center">
                        @if ($editingId === $booking->id)
                            <select wire:model.defer="editServiceId" class="border p-1 w-full rounded">
                                @foreach(\App\Models\Service::all() as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        @else
                            {{ $booking->service->name }}
                        @endif
                    </td>
                    <td class="p-2 border text-center">
                        @if ($editingId === $booking->id)
                            <select wire:model.defer="editStaffId" class="border p-1 w-full rounded">
                                @foreach(\App\Models\Staff::all() as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        @else
                            {{ $booking->staff->name }}
                        @endif
                    </td>
                    <td class="p-2 border text-center">{{ $booking->schedule->date }} @ {{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</td>
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
