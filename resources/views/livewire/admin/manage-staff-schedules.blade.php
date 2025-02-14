<div>
    <h2 class="text-xl font-bold mb-4">Manage Staff Schedules</h2>

    <form wire:submit.prevent="{{ $isEditing ? 'updateSchedule' : 'createSchedule' }}">
        <select wire:model="staff_id">
            <option value="">Select Staff</option>
            @foreach($staff as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
            @endforeach
        </select>

        <input type="date" wire:model="date">
        <input type="time" wire:model="start_time">
        <input type="time" wire:model="end_time">

        <button type="submit">{{ $isEditing ? 'Update' : 'Add' }}</button>
    </form>

    <table>
        <tr>
            <th>Staff</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Actions</th>
        </tr>
        @foreach($schedules as $schedule)
            <tr>
                <td>{{ $schedule->staff->name }}</td>
                <td>{{ $schedule->date }}</td>
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                <td>
                    <button wire:click="editSchedule({{ $schedule->id }})">Edit</button>
                    <button wire:click="deleteSchedule({{ $schedule->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $schedules->links() }}
</div>
