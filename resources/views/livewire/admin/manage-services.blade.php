<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Services</h2>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4 mt-4">
        <input type="text" wire:model.live="search" class="border p-2 w-full mb-4" placeholder="Search services...">
    </div>
    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Service Name</th>
                <th class="p-2 border">Price</th>
                <th class="p-2 border">Description</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- New Row for Adding a Service -->
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">#</td>
                <td class="p-2 border">
                    <input type="text" wire:model="newService" wire:keydown.enter="addService" class="border p-1 w-full" placeholder="Enter service name">
                </td>
                <td class="p-2 border">
                    <input type="number" wire:model="newPrice" class="border p-1 w-full" placeholder="Enter price">
                </td>
                <td class="p-2 border">
                    <input type="text" wire:model="newDescription" class="border p-1 w-full" placeholder="Enter description">
                </td>
                <td class="p-2 border">
                    <button wire:click="addService" class="bg-green-500 text-white px-2 py-1 rounded">Save</button>
                </td>
            </tr>

            <!-- Existing Services -->
            @foreach($services as $service)
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">{{ $service->id }}</td>
                <td class="p-2 border">
                    @if ($editingId === $service->id)
                        <input type="text" wire:model="editName" class="border p-1 w-full">
                    @else
                        {{ $service->name }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $service->id)
                        <input type="number" wire:model="editPrice" class="border p-1 w-full">
                    @else
                        ${{ $service->price }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $service->id)
                        <input type="text" wire:model="editDescription" class="border p-1 w-full">
                    @else
                        {{ $service->description }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $service->id)
                        <button wire:click="saveEdit({{ $service->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                    @else
                        <button wire:click="editService({{ $service->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $service->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Confirmation Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this service?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteService({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
