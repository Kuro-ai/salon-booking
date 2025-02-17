<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Advertisements</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif
    <div class="mb-4 mt-4">
        <input type="text" wire:model.live="search" placeholder="Search by title..." class="border p-2 w-full rounded">
    </div>
    
    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border w-1/6">Image</th>
                <th class="p-2 border">Title</th>
                <th class="p-2 border">Text</th>
                <th class="p-2 border">Link</th>
                <th class="p-2 border w-1/6">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- New Advertisement Row -->
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border text-center">
                    <input type="file" wire:model="newImage">
                    @if ($newImage)
                        <img src="{{ $newImage->temporaryUrl() }}" class="w-32 h-20 mt-2 rounded shadow mx-auto">
                    @endif
                </td>
                <td class="p-2 border">
                    <input type="text" wire:model="newTitle" placeholder="Enter title" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="text" wire:model="newText" placeholder="Enter text" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="text" wire:model="newLink" placeholder="Enter link" class="border p-1 w-full">
                </td>
                <td class="p-2 border text-center">
                    <button wire:click="addAd" class="bg-green-500 text-white px-2 py-1 rounded">Save</button>
                </td>
            </tr>

            <!-- Existing Advertisements -->
            @foreach($ads as $ad)
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border text-center">
                    @if ($editingId === $ad['id'])
                        <input type="file" wire:model="editImage">
                        @if ($editImage)
                            <img src="{{ $editImage->temporaryUrl() }}" class="w-32 h-20 mt-2 rounded shadow mx-auto">
                        @else
                            <img src="{{ asset('storage/'.$ad['image']) }}" class="w-32 h-20 mt-2 rounded shadow mx-auto">
                        @endif
                    @else
                        <img src="{{ asset('storage/'.$ad['image']) }}" class="w-32 h-20 rounded shadow mx-auto">
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $ad['id'])
                        <input type="text" wire:model="editTitle" class="border p-1 w-full">
                    @else
                        {{ $ad['title'] }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $ad['id'])
                        <input type="text" wire:model="editText" class="border p-1 w-full">
                    @else
                        {{ $ad['text'] }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $ad['id'])
                        <input type="text" wire:model="editLink" class="border p-1 w-full">
                    @else
                        <a href="{{ $ad['link'] }}" target="_blank" class="text-blue-500 underline">{{ $ad['link'] }}</a>
                    @endif
                </td>
                <td class="p-2 border text-center">
                    @if ($editingId === $ad['id'])
                        <button wire:click="saveEdit({{ $ad['id'] }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                    @else
                        <button wire:click="editAd({{ $ad['id'] }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $ad['id'] }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
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
            <p>Are you sure you want to delete this advertisement?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteAd({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
