<div>
    <h2 class="text-xl font-bold mb-4">Manage Staff</h2>
    
    <form wire:submit.prevent="{{ $isEditing ? 'updateStaff' : 'createStaff' }}">
        <input type="text" wire:model="name" placeholder="Staff Name">
        <input type="text" wire:model="specialty" placeholder="Specialty">
        <button type="submit">{{ $isEditing ? 'Update' : 'Add' }}</button>
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Specialty</th>
            <th>Actions</th>
        </tr>
        @foreach($staff as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->specialty }}</td>
                <td>
                    <button wire:click="editStaff({{ $member->id }})">Edit</button>
                    <button wire:click="deleteStaff({{ $member->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $staff->links() }}
</div>
