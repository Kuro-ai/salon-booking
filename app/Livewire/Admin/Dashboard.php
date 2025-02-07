<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalUsers;
    public $totalOrders;
    public $totalSales;
    public $filter = '30_days'; // Default filter
    public $salesData = []; // Data for Chart.js

    public function mount()
    {
        $this->updateDashboard();
    }

    public function updateDashboard()
    {
        $this->totalUsers = \App\Models\User::count();
        $this->totalOrders = Order::count();
        $this->totalSales = Order::where('status', 'delivered')->sum('total_price');

        $this->salesData = $this->getSalesData();
        $this->dispatch('updateChart', ['salesData' => $this->salesData]);
    }

    private function getSalesData()
    {
        $query = Order::where('status', 'delivered');

        // Apply filter
        if ($this->filter == '7_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($this->filter == '30_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }

        return $query->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => $item->total
                ];
            })
            ->toArray();
    }

    public function updatedFilter()
    {
        $this->updateDashboard();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
