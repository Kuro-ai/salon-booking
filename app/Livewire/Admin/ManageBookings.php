<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceBooking;
use App\Models\StaffSchedule;
use Illuminate\Support\Facades\Hash;
class ManageBookings extends Component
{
    use WithPagination;

    public $editingId = null;
    public $editStatus = '';
    public $editCustomerName;
    public $editServiceId;
    public $editStaffId;
    public $confirmingDelete = null;
    public $searchName = '';
    public $searchDate = '';
    public $statusFilter = '';
    public $newCustomerName = '';
    public $newServiceId = null;
    public $newStaffId = null;
    public $newScheduleId = null;
    public $newStatus = 'pending';

    protected $paginationTheme = 'tailwind'; // Ensures consistent styling

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function updatingSearchDate()
    {
        $this->resetPage();
    }

    public function loadBookings()
    {
        $query = ServiceBooking::query();

        if (!empty($this->searchName)) {
            $query->whereHas('user', function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchName) . '%']);
            });
        }

        if (!empty($this->searchDate)) {
            $query->whereHas('schedule', function ($q) {
                $q->whereDate('date', $this->searchDate);
            });
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (!empty($this->searchName)) {
            $query->orWhereHas('staff', function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchName) . '%']);
            });
        }

        return $query->latest()->paginate(10);
    }

    public function addBooking()
    {
        $this->validate([
            'newCustomerName' => 'required|string|max:255',
            'newServiceId' => 'required|exists:services,id',
            'newStaffId' => 'required|exists:staff,id',
            'newScheduleId' => 'required|exists:staff_schedules,id',
            'newStatus' => 'required|in:pending,approved,cancelled',
        ]);

        $user = \App\Models\User::firstOrCreate(
            ['name' => $this->newCustomerName],
            [
                'email' => strtolower(str_replace(' ', '_', $this->newCustomerName)) . '@dummy.local',
                'role' => 'customer',
                'password' => Hash::make('password'),
            ]
        );    

        $booking = \App\Models\ServiceBooking::create([
            'user_id' => $user->id,
            'service_id' => $this->newServiceId,
            'staff_id' => $this->newStaffId,
            'schedule_id' => $this->newScheduleId,
            'status' => $this->newStatus,
        ]);

        $booking->schedule->update(['is_booked' => true]);

        $this->reset(['newCustomerName', 'newServiceId', 'newStaffId', 'newScheduleId', 'newStatus']);

        session()->flash('message', 'Booking added successfully.');
    }

    public function editBooking($id, $status)
    {
        $this->editingId = $id;
        $this->editStatus = $status;

        $booking = ServiceBooking::find($id);
        if ($booking) {
            $this->editCustomerName = $booking->user->name;
            $this->editServiceId = $booking->service_id;
            $this->editStaffId = $booking->staff_id;
        }
    }

    public function saveEdit($id)
    {
        $booking = ServiceBooking::find($id);
        if ($booking) {
            $booking->update([
                'service_id' => $this->editServiceId,
                'staff_id' => $this->editStaffId,
                'status' => $this->editStatus,
            ]);

            $booking->user->update(['name' => $this->editCustomerName]);

            if ($this->editStatus === 'cancelled') {
                $booking->schedule->update(['is_booked' => false]);
            }

            session()->flash('message', 'Booking updated successfully.');
        }

        $this->cancelEdit();
    }


    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editStatus = '';
        $this->editCustomerName = null;
        $this->editServiceId = null;
        $this->editStaffId = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteBooking($id)
    {
        $booking = ServiceBooking::find($id);
        if ($booking) {

            if ($booking->schedule) {
                $booking->schedule->update(['is_booked' => false]);
            }

            $booking->delete();
            session()->flash('message', 'Booking deleted successfully.');
        }

        $this->confirmingDelete = null;
    }

    public function render()
    {
        return view('livewire.admin.manage-bookings', [
            'bookings' => $this->loadBookings(),
        ]);
    }
}
