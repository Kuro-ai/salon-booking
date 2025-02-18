<div x-data class="max-w-lg mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-xl font-semibold text-gray-800 mb-3">Select a Staff Member</h2>
    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4 mb-4 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4 mb-4 rounded-lg shadow">
            {{ session('error') }}
        </div>
    @endif
    <div class="relative">
        <select wire:model.live="selectedStaff" 
                class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300">
            <option value="">Choose Staff</option>
            @foreach ($staff as $person)
                <option value="{{ $person->id }}">{{ $person->name }}</option>
            @endforeach
        </select>
    </div>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">Available Time Slots</h2>

    <ul class="mt-3 space-y-2">
        @foreach ($schedules as $schedule)
            <li wire:key="schedule-{{ $schedule['id'] }}">
                <button 
                    x-on:click="if(confirm('Are you sure you want to book this slot? The booking is automatically cancelled if you are late for half an hour!')) 
                        $wire.confirmBooking({{ $schedule['id'] }})"
                    class="w-full flex justify-between items-center bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition shadow-md">
                    <span>{{ $schedule['date'] }} - {{ $schedule['start_time'] }} to {{ $schedule['end_time'] }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" 
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </li>
        @endforeach
    </ul>

    
</div>
