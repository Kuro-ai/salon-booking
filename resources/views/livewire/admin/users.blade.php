<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Users</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Search by email..." class="border p-2 rounded w-full">
    </div>

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">Role</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    #
                </td>
                <td class="p-2 border">
                    <input type="text" wire:model="newName" placeholder="Name" class="border p-2 rounded w-full">
                </td>
                <td class="p-2 border">
                    <input type="email" wire:model="newEmail" placeholder="Email" class="border p-2 rounded w-full">
                </td>
                <td class="p-2 border">
                    <select wire:model="newRole" class="border p-2 rounded w-full">
                        <option value="admin">Admin</option>
                        <option value="customer">Customer</option>
                    </select>
                </td>
                <td class="p-2 border text-center">
                    <button wire:click="addUser" class="mt-4 bg-green-500 text-white px-3 py-1 rounded">Add</button>
                </td>
            </tr>
            @foreach($users as $user)
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">{{ $user->id }}</td>
                <td class="p-2 border">
                    @if ($editingId === $user->id)
                        <input type="text" wire:model="editName" class="border p-1 w-full">
                    @else
                        {{ $user->name }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $user->id)
                        <input type="email" wire:model="editEmail" class="border p-1 w-full">
                    @else
                        {{ $user->email }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $user->id)
                        <select wire:model="editRole" class="border p-1 w-full">
                            <option value="admin">Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                    @else
                        {{ ucfirst($user->role) }}
                    @endif
                </td>
                <td class="p-2 border text-center">
                    @if ($editingId === $user->id)
                        <button wire:click="saveEdit({{ $user->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                    @else
                        <button wire:click="editUser({{ $user->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $user->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Confirmation Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this user?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteUser({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
