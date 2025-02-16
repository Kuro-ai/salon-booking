<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ServiceBooking;
use Illuminate\Support\Facades\Session;

class ManageBookings extends Component
{
    public function approveBooking($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);

        if ($booking && $booking->status === 'pending') {
            $booking->update(['status' => 'approved']);
            session()->flash('success', 'Booking approved successfully.');
        }
    }

    public function cancelBooking($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);

        if ($booking && $booking->status !== 'cancelled') {
            $booking->update(['status' => 'cancelled']);
            $booking->schedule->update(['is_booked' => false]); // Free the schedule
            session()->flash('success', 'Booking cancelled successfully.');
        }
    }

    public function deleteBooking($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);

        if ($booking) {
            $booking->delete();
            session()->flash('success', 'Booking deleted successfully.');
        }
    }

    public function render()
    {
        return view('livewire.admin.manage-bookings', [
            'bookings' => ServiceBooking::latest()->get(),
        ]);
    }
}
