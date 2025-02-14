<div>
    <h2 class="text-xl font-bold mb-4">Manage Advertisements</h2>

    <input type="file" wire:model="image">
    <input type="text" wire:model="title" placeholder="Ad Title">
    <input type="text" wire:model="text" placeholder="Ad Text">
    <input type="text" wire:model="link" placeholder="Redirect Link">
    <button wire:click="addAd">Add Advertisement</button>

    <table>
        <tr><th>Image</th><th>Title</th><th>Actions</th></tr>
        @foreach($ads as $ad)
        <tr>
            <td><img src="{{ asset('storage/'.$ad->image) }}" width="100"></td>
            <td>{{ $ad->title }}</td>
            <td>{{ $ad->text }}</td>
            <td>
                <button wire:click="deleteAd({{ $ad->id }})">Delete</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
