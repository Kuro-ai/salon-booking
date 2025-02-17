<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceBooking;

class ManageBookings extends Component
{
    use WithPagination;

    public $editingId = null;
    public $editStatus = '';
    public $confirmingDelete = null;
    public $searchName = '';
    public $searchDate = '';

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

        // Filter by customer name (case-insensitive)
        if (!empty($this->searchName)) {
            $query->whereHas('user', function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchName) . '%']);
            });
        }

        // Filter by date
        if (!empty($this->searchDate)) {
            $query->whereHas('schedule', function ($q) {
                $q->whereDate('date', $this->searchDate);
            });
        }

        return $query->latest()->paginate(10);
    }

    public function editBooking($id, $status)
    {
        $this->editingId = $id;
        $this->editStatus = $status;
    }

    public function saveEdit($id)
    {
        $booking = ServiceBooking::find($id);
        if ($booking) {
            $booking->update(['status' => $this->editStatus]);

            // Free schedule slot if cancelled
            if ($this->editStatus === 'cancelled') {
                $booking->schedule->update(['is_booked' => false]);
            }

            session()->flash('message', 'Booking status updated successfully.');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editStatus = '';
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
