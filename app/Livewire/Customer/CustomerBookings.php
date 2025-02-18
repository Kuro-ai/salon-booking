<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceBooking;
use Illuminate\Support\Facades\Auth;

class CustomerBookings extends Component
{
    use WithPagination;

    public function cancelBooking($bookingId)
    {
        $booking = ServiceBooking::where('id', $bookingId)->where('user_id', Auth::id())->first();

        if (!$booking || $booking->status !== 'pending') {
            session()->flash('error', 'Booking cannot be cancelled.');
            return;
        }

        $booking->update(['status' => 'cancelled']);
        $booking->schedule->update(['is_booked' => false]);

        session()->flash('success', 'Booking cancelled successfully.');
    }

    public function render()
    {
        return view('livewire.customer.customer-bookings', [
            'bookings' => ServiceBooking::where('user_id', Auth::id())->latest()->paginate(10),
        ]);
    }
}
