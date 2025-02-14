<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Service;

class ServicesList extends Component
{
    public function render()
    {
        return view('livewire.customer.services-list', [
            'services' => Service::all(),
        ]);
    }
}

