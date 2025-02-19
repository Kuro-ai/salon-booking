<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Staff</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mt-4 mb-4">
        <input type="text" wire:model.live="search" placeholder="Search staff by name..."
        class="border p-2 w-full mb-4 rounded">
    </div>

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">Phone Number</th>
                <th class="p-2 border">Address</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- New Staff Row -->
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border"><input type="text" wire:model="newName" placeholder="Staff Name" class="border p-1 w-full"></td>
                <td class="p-2 border"><input type="email" wire:model="newEmail" placeholder="Email" class="border p-1 w-full"></td>
                <td class="p-2 border"><input type="text" wire:model="newPhoneNumber" placeholder="Phone Number" class="border p-1 w-full"></td>
                <td class="p-2 border"><input type="text" wire:model="newAddress" placeholder="Address" class="border p-1 w-full"></td>
                <td class="p-2 border text-center">
                    <button wire:click="addStaff" class="bg-green-500 text-white px-2 py-1 rounded">Add</button>
                </td>
            </tr>

            <!-- Existing Staff -->
            @foreach($staff as $member)
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    @if ($editingId === $member->id)
                        <input type="text" wire:model="editName" class="border p-1 w-full">
                    @else
                        {{ $member->name }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $member->id)
                        <input type="email" wire:model="editEmail" class="border p-1 w-full">
                    @else
                        {{ $member->email }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $member->id)
                        <input type="text" wire:model="editPhoneNumber" class="border p-1 w-full">
                    @else
                        {{ $member->phone_number }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $member->id)
                        <input type="text" wire:model="editAddress" class="border p-1 w-full">
                    @else
                        {{ $member->address }}
                    @endif
                </td>
                <td class="p-2 border text-center">
                    @if ($editingId === $member->id)
                        <button wire:click="saveEdit({{ $member->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                    @else
                        <button wire:click="editStaff({{ $member->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $member->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this staff member?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteStaff({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
