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
                ->get()
                ->toArray();
        } else {
            $this->schedules = [];
        }
    }

    public function bookService($scheduleId)
    {
        $schedule = StaffSchedule::find($scheduleId);
        
        if (!$schedule || $schedule->is_booked) {
            session()->flash('error', 'Schedule not available.');
            return;
        }

        // Emit event for confirmation
        $this->dispatch('confirmBooking', $scheduleId);
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
            'status' => 'approved', // Auto-approve
        ]);

        $schedule->update(['is_booked' => true]);

        session()->flash('success', 'Booking confirmed!');
    }

    public function render()
    {
        return view('livewire.customer.staff-schedules', [
            'staff' => Staff::all(),
        ]);
    }
}
