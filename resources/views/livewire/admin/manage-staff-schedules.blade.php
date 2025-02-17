<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Staff Schedules</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex space-x-4 mb-4">
        <input type="text" wire:model.live="searchName" placeholder="Search by staff name"
            class="border p-2 w-1/2" />
        <input type="date" wire:model.live="searchDate" class="border p-2 w-1/2"/>
    </div>

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Staff</th>
                <th class="p-2 border">Date</th>
                <th class="p-2 border">Start Time</th>
                <th class="p-2 border">End Time</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- New Schedule Row -->
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    <select wire:model="newStaffId" class="border p-1 w-full">
                        <option value="">Select Staff</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-2 border"><input type="date" wire:model="newDate" class="border p-1 w-full" min="{{ \Carbon\Carbon::now()->toDateString() }}"></td>
                <td class="p-2 border"><input type="time" wire:model="newStartTime" class="border p-1 w-full"></td>
                <td class="p-2 border"><input type="time" wire:model="newEndTime" class="border p-1 w-full"></td>
                <td class="p-2 border text-center">
                    <button wire:click="addSchedule" class="bg-green-500 text-white px-2 py-1 rounded">Add</button>
                </td>
            </tr>

            <!-- Existing Schedules -->
            @foreach($schedules as $schedule)
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    @if ($editingId === $schedule->id)
                        <select wire:model="editStaffId" class="border p-1 w-full">
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    @else
                        {{ $schedule->staff->name }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $schedule->id)
                        <input type="date" wire:model="editDate" class="border p-1 w-full" min="{{ \Carbon\Carbon::now()->toDateString() }}">
                    @else
                        {{ $schedule->date }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $schedule->id)
                        <input type="time" wire:model="editStartTime" class="border p-1 w-full">
                    @else
                        {{ $schedule->start_time }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $schedule->id)
                        <input type="time" wire:model="editEndTime" class="border p-1 w-full">
                    @else
                        {{ $schedule->end_time }}
                    @endif
                </td>
                <td class="p-2 border text-center">
                    @if ($editingId === $schedule->id)
                        <button wire:click="saveEdit({{ $schedule->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                    @else
                        <button wire:click="editSchedule({{ $schedule->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $schedule->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
    <!-- Confirmation Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this schedule?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteSchedule({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
