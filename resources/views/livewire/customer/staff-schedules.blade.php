<div x-data>
    <h2 class="text-lg font-bold">Select a Staff Member</h2>
    <select wire:model.live="selectedStaff">
        <option value="">Choose Staff</option>
        @foreach ($staff as $person)
            <option value="{{ $person->id }}">{{ $person->name }} ({{ $person->specialty }})</option>
        @endforeach
    </select>
    
    <h2 class="text-lg font-bold mt-4">Available Time Slots</h2>
    <ul>
        @foreach ($schedules as $schedule)
            <li wire:key="schedule-{{ $schedule['id'] }}">
                <button 
                    x-on:click="if(confirm('Are you sure you want to book this slot?')) { Livewire.dispatch('confirmBooking', {{ $schedule['id'] }}) }" 
                    class="bg-blue-500 text-white px-3 py-1">
                    {{ $schedule['date'] }} - {{ $schedule['start_time'] }} to {{ $schedule['end_time'] }}
                </button>
            </li>
        @endforeach
    </ul>    

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-3 mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-200 text-red-700 p-3 mt-3">
            {{ session('error') }}
        </div>
    @endif
</div>
