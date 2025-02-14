<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Carbon\Carbon;

class ManageStaffSchedules extends Component
{
    use WithPagination;

    public $staff_id, $date, $start_time, $end_time, $scheduleId;
    public $isEditing = false;

    protected $rules = [
        'staff_id' => 'required|exists:staff,id',
        'date' => 'required|date|after_or_equal:today',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
    ];

    public function createSchedule()
    {
        $this->validate();

        StaffSchedule::create([
            'staff_id' => $this->staff_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_booked' => false,
        ]);

        $this->resetForm();
    }

    public function editSchedule($id)
    {
        $schedule = StaffSchedule::findOrFail($id);
        $this->scheduleId = $id;
        $this->staff_id = $schedule->staff_id;
        $this->date = $schedule->date;
        $this->start_time = $schedule->start_time;
        $this->end_time = $schedule->end_time;
        $this->isEditing = true;
    }

    public function updateSchedule()
    {
        $this->validate();

        StaffSchedule::where('id', $this->scheduleId)->update([
            'staff_id' => $this->staff_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $this->resetForm();
    }

    public function deleteSchedule($id)
    {
        StaffSchedule::destroy($id);
    }

    private function resetForm()
    {
        $this->staff_id = $this->date = $this->start_time = $this->end_time = null;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.admin.manage-staff-schedules', [
            'staff' => Staff::all(),
            'schedules' => StaffSchedule::with('staff')->paginate(10),
        ]);
    }
}

