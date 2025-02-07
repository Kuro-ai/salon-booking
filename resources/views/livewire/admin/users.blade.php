<div class="p-4">
    <h2 class="text-lg font-bold mb-4">Manage Users</h2>

    <table class="w-full border">
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
            @foreach($users as $user)
            <tr>
                <td class="p-2 border">{{ $user->id }}</td>
                <td class="p-2 border">{{ $user->name }}</td>
                <td class="p-2 border">{{ $user->email }}</td>
                <td class="p-2 border">
                    <select wire:change="updateRole({{ $user->id }}, $event.target.value)" class="border p-1">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </td>
                <td class="p-2 border">
                    <button wire:click="deleteUser({{ $user->id }})" class="bg-red-500 text-white px-2 py-1">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
