<div class="p-4">
    <h2 class="text-lg font-bold mb-4">Manage Categories</h2>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Category Name</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- New Row for Adding a Category -->
            <tr>
                <td class="p-2 border">#</td>
                <td class="p-2 border">
                    <input type="text" wire:model="newCategory" wire:keydown.enter="addCategory" class="border p-1 w-full" placeholder="Enter category name">
                </td>
                <td class="p-2 border">
                    <button wire:click="addCategory" class="bg-green-500 text-white px-2 py-1">Save</button>
                </td>
            </tr>

            <!-- Existing Categories -->
            @foreach($categories as $category)
            <tr>
                <td class="p-2 border">{{ $category->id }}</td>
                <td class="p-2 border">
                    <input type="text" wire:blur="updateCategory({{ $category->id }}, 'name', $event.target.value)" value="{{ $category->name }}" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <button wire:click="deleteCategory({{ $category->id }})" class="bg-red-500 text-white px-2 py-1">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
