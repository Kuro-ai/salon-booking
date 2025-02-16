<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\ServiceBooking;
use App\Models\StaffSchedule;
use Illuminate\Support\Facades\Auth;

class CustomerBookings extends Component
{
    public function cancelBooking($bookingId)
    {
        $booking = ServiceBooking::where('id', $bookingId)->where('user_id', Auth::id())->first();

        if (!$booking) {
            session()->flash('error', 'Booking not found.');
            return;
        }
        $booking->update(['status' => 'cancelled']);
        $booking->schedule->update(['is_booked' => false]);

        session()->flash('success', 'Booking cancelled successfully.');
    }

    public function render()
    {
        return view('livewire.customer.customer-bookings', [
            'bookings' => ServiceBooking::where('user_id', Auth::id())->latest()->get(),
        ]);
    }
}
