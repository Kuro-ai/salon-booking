<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\StaffSchedule;
use App\Models\Staff;
use App\Models\ServiceBooking;
use Illuminate\Support\Facades\Auth;

class StaffSchedules extends Component
{
    public $serviceId;
    public $selectedStaff;
    public $schedules = [];

    public function mount($serviceId)
    {
        $this->serviceId = $serviceId;
    }

    public function updatedSelectedStaff()
    {
        if ($this->selectedStaff) {
            $this->schedules = StaffSchedule::where('staff_id', $this->selectedStaff)
                ->where('is_booked', false)
                ->where(function ($query) {
                    $query->where('date', '>', now()->toDateString())
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('date', now()->toDateString())
                                    ->where('start_time', '>', now()->format('H:i:s'));
                        });
                })
                ->get()
                ->toArray();
        } else {
            $this->schedules = [];
        }
    }

    public function bookService($scheduleId)
    {
        // Dispatch a Livewire event to the frontend
        $this->dispatch('confirm-booking', scheduleId: $scheduleId);
    }

    public function confirmBooking($scheduleId)
    {
        $schedule = StaffSchedule::find($scheduleId);
        
        if (!$schedule || $schedule->is_booked) {
            session()->flash('error', 'Schedule not available.');
            return;
        }

        ServiceBooking::create([
            'user_id' => Auth::id(),
            'service_id' => $this->serviceId,
            'staff_id' => $schedule->staff_id,
            'schedule_id' => $schedule->id,
            'status' => 'pending', // Set status to pending
        ]);

        $schedule->update(['is_booked' => true]);

        session()->flash('success', 'Booking confirmed!');

        // Redirect to home page
        return redirect()->route('customer.dashboard');
    }

    public function render()
    {
        return view('livewire.customer.staff-schedules', [
            'staff' => Staff::all(),
        ]);
    }
}

