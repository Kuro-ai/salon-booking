<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StaffSchedule;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class ManageStaffSchedules extends Component
{
    use WithPagination;
    
    public $staff;
    public $newStaffId, $newDate, $newStartTime, $newEndTime;
    
    public $editingId = null;
    public $editStaffId, $editDate, $editStartTime, $editEndTime;

    public $confirmingDelete = null;

    public $searchName = '', $searchDate = '';

    protected $rules = [
        'newStaffId' => 'required|exists:staff,id',
        'newDate' => 'required|date',
        'newStartTime' => 'required',
        'newEndTime' => 'required|after:newStartTime',
    ];

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function updatingSearchDate()
    {
        $this->resetPage();
    }
    
    public function mount()
    {
        $this->staff = Staff::orderBy('name')->get();
    }

    public function loadData()
    {
        $query = StaffSchedule::with('staff');

        if (!empty($this->searchName)) {
            $query->whereHas('staff', function ($q) {
                $q->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->searchName) . '%');
            });
        }

        if (!empty($this->searchDate)) {
            $query->whereDate('date', $this->searchDate);
        }

        return $query->orderBy('id', 'desc')->paginate(10);
    }

    public function addSchedule()
    {
        $this->validate();

        StaffSchedule::create([
            'staff_id' => $this->newStaffId,
            'date' => $this->newDate,
            'start_time' => $this->newStartTime,
            'end_time' => $this->newEndTime,
        ]);

        session()->flash('message', 'Schedule added successfully!');
        $this->resetNewSchedule();
    }

    public function editSchedule($id)
    {
        $schedule = StaffSchedule::findOrFail($id);
        $this->editingId = $id;
        $this->editStaffId = $schedule->staff_id;
        $this->editDate = $schedule->date;
        $this->editStartTime = $schedule->start_time;
        $this->editEndTime = $schedule->end_time;
    }

    public function saveEdit($id)
    {
        $schedule = StaffSchedule::find($id);

        if ($schedule) {
            $schedule->update([
                'staff_id' => $this->editStaffId,
                'date' => $this->editDate,
                'start_time' => $this->editStartTime,
                'end_time' => $this->editEndTime,
            ]);

            session()->flash('message', 'Schedule updated successfully!');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editStaffId = $this->editDate = $this->editStartTime = $this->editEndTime = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteSchedule($id)
    {
        StaffSchedule::destroy($id);
        session()->flash('message', 'Schedule deleted successfully!');
        $this->confirmingDelete = null;
    }

    private function resetNewSchedule()
    {
        $this->newStaffId = $this->newDate = $this->newStartTime = $this->newEndTime = null;
    }

    public function render()
    {
        return view('livewire.admin.manage-staff-schedules', [
            'schedules' => $this->loadData(),
        ]);
    }
}
