<div>
    <h2 class="text-xl font-bold mb-4">Manage Services</h2>
    
    <form wire:submit.prevent="{{ $isEditing ? 'updateService' : 'createService' }}">
        <input type="text" wire:model="name" placeholder="Service Name">
        <input type="number" wire:model="price" placeholder="Price">
        <textarea wire:model="description" placeholder="Description"></textarea>
        <button type="submit">{{ $isEditing ? 'Update' : 'Add' }}</button>
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        @foreach($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>${{ $service->price }}</td>
                <td>{{ $service->description }}</td>
                <td>
                    <button wire:click="editService({{ $service->id }})">Edit</button>
                    <button wire:click="deleteService({{ $service->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $services->links() }}
</div>
