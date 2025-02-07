<div class="p-4">
    <h2 class="text-lg font-bold mb-4">Manage Products</h2>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Description</th>
                <th class="p-2 border">Price</th>
                <th class="p-2 border">Stock</th>
                <th class="p-2 border">Category</th>
                <th class="p-2 border">Image</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- New Product Row -->
            <tr>
                <td class="p-2 border">#</td>
                <td class="p-2 border">
                    <input type="text" wire:model="newProduct.name" class="border p-1 w-full" placeholder="Enter name">
                </td>
                <td class="p-2 border">
                    <input type="text" wire:model="newProduct.description" class="border p-1 w-full" placeholder="Description">
                </td>
                <td class="p-2 border">
                    <input type="number" wire:model="newProduct.price" class="border p-1 w-full" placeholder="Price">
                </td>
                <td class="p-2 border">
                    <input type="number" wire:model="newProduct.stock" class="border p-1 w-full" placeholder="Stock">
                </td>
                <td class="p-2 border">
                    <select wire:model="newProduct.category_id" class="border p-1 w-full">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-2 border">
                    <input type="file" wire:model="newProduct.image">
                    
                    <!-- Show preview if an image is selected -->
                    @if ($newProduct['image'])
                        <img src="{{ $newProduct['image']->temporaryUrl() }}" class="w-16 h-16 mt-2">
                    @endif
                </td>
                
                <td class="p-2 border">
                    <button wire:click="addProduct" class="bg-green-500 text-white px-2 py-1">Save</button>
                </td>
            </tr>

            <!-- Existing Products -->
            @foreach($products as $product)
            <tr>
                <td class="p-2 border">{{ $product->id }}</td>
                <td class="p-2 border">
                    <input type="text" wire:blur="updateProduct({{ $product->id }}, 'name', $event.target.value)" value="{{ $product->name }}" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="text" wire:blur="updateProduct({{ $product->id }}, 'description', $event.target.value)" value="{{ $product->description }}" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="number" wire:blur="updateProduct({{ $product->id }}, 'price', $event.target.value)" value="{{ $product->price }}" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <input type="number" wire:blur="updateProduct({{ $product->id }}, 'stock', $event.target.value)" value="{{ $product->stock }}" class="border p-1 w-full">
                </td>
                <td class="p-2 border">
                    <select wire:change="updateProduct({{ $product->id }}, 'category_id', $event.target.value)" class="border p-1 w-full">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-2 border">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16">
                </td>
                <td class="p-2 border">
                    <button wire:click="deleteProduct({{ $product->id }})" class="bg-red-500 text-white px-2 py-1">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
