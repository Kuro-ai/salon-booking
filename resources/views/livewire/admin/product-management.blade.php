<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Products</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search and Category Filter Inputs -->
    <div class="mb-4 flex gap-4">
        <input type="text" wire:model.live="search" placeholder="Search by name..." class="border p-2 rounded w-1/2">
        <select wire:model="categoryFilter" class="border p-2 rounded w-1/2">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Product Table -->
    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border w-1/6">Name</th>
                <th class="p-2 border w-1/4">Description</th>
                <th class="p-2 border w-1/12">Price</th>
                <th class="p-2 border w-1/12">Stock</th>
                <th class="p-2 border w-1/6">Category</th>
                <th class="p-2 border w-1/6">Image</th>
                <th class="p-2 border w-1/6">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Add New Product Row -->
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    <input type="text" wire:model="newProductName" placeholder="Name" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="text" wire:model="newProductDescription" placeholder="Description" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="number" wire:model="newProductPrice" placeholder="Price" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="number" wire:model="newProductStock" placeholder="Stock" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <select wire:model="newProductCategoryId" class="border p-1 w-full">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-2 border text-center">
                    <input type="file" wire:model="newProductImage">
                    @if ($newProductImage)
                        <img src="{{ $newProductImage->temporaryUrl() }}" class="w-32 h-20 mt-2 rounded shadow mx-auto">
                    @endif
                </td>
                <td class="p-2 border text-center">
                    <button wire:click="addProduct" class="bg-green-500 text-white px-2 py-1 rounded">Add</button>
                </td>
            </tr>

            <!-- List Existing Products -->
            @foreach($products as $product)
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    @if ($editingId === $product->id)
                        <input type="text" wire:model="editName" class="border p-1 w-full">
                    @else
                        {{ $product->name }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $product->id)
                        <input type="text" wire:model="editDescription" class="border p-1 w-full">
                    @else
                        {{ $product->description }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $product->id)
                        <input type="number" wire:model="editPrice" class="border p-1 w-full">
                    @else
                        {{ $product->price }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $product->id)
                        <input type="number" wire:model="editStock" class="border p-1 w-full">
                    @else
                        {{ $product->stock }}
                    @endif
                </td>
                <td class="p-2 border">{{ $product->category->name }}</td>
                <td class="p-2 border text-center">
                    @if ($editingId === $product->id)
                        <input type="file" wire:model="editImage">
                        @if ($editImage)
                            <img src="{{ $editImage->temporaryUrl() }}" class="w-32 h-20 mt-2 rounded shadow mx-auto">
                        @elseif ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-20 mt-2 rounded shadow mx-auto">
                        @endif
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-20 rounded shadow mx-auto">
                    @endif
                </td>
                <td class="p-2 border text-center">
                    @if ($editingId === $product->id)
                        <div class="flex justify-center gap-2">
                            <button wire:click="saveEdit({{ $product->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                            <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                        </div>
                    @else
                        <div class="flex justify-center gap-2">
                            <button wire:click="editProduct({{ $product->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                            <button wire:click="confirmDelete({{ $product->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingDelete)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-5 rounded shadow-lg">
                <p class="text-lg font-semibold mb-4">Are you sure you want to delete this product?</p>
                <div class="flex justify-center gap-4">
                    <button wire:click="deleteProduct({{ $confirmingDelete }})" class="bg-red-500 text-white px-4 py-2 rounded">Yes</button>
                    <button wire:click="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded">No</button>
                </div>
            </div>
        </div>
    @endif
</div>
