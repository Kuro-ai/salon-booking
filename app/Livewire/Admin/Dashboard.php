<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalUsers;
    public $totalOrders;
    public $totalSales;
    public $salesChart;
    public $filter = '30_days'; // Default filter
    public $bestSellingProducts = [];
    public $topCustomers = [];
    public $averageOrderValue;
    public $revenuePerCategory;
    public $dailyRevenue;
    public $customerOrderFrequency;
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->subDays(7)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->updateDashboard();
    }

    private function getDailyRevenue()
    {
        return Order::where('status', 'delivered')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('date')
            ->orderByDesc('date')
            ->take(7)
            ->get();
    }

    private function getCustomerOrderFrequency()
    {
        return User::join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.name', DB::raw('COUNT(orders.id) as total_orders'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_orders')
            ->get();
    }

    public function updateDashboard()
    {
        $this->totalUsers = User::count();
        $this->totalOrders = Order::count();
        $this->totalSales = Order::where('status', 'delivered')->sum('total_price');

        $this->salesChart = $this->generateSalesChart();
        $this->bestSellingProducts = $this->getBestSellingProducts();
        $this->topCustomers = $this->getTopCustomers();
        $this->revenuePerCategory = $this->getRevenuePerCategory();
        $this->averageOrderValue = $this->getAverageOrderValue();
        $this->dailyRevenue = $this->getDailyRevenue();
        $this->customerOrderFrequency = $this->getCustomerOrderFrequency();

        $this->dailyRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        $this->customerOrderFrequency = User::join('orders', 'users.id', '=', 'orders.user_id')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->select('users.name', DB::raw('COUNT(orders.id) as total_orders'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_orders')
            ->get();
    }


    private function generateSalesChart()
    {
        $query = Order::where('status', 'delivered');

        if ($this->filter == '7_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($this->filter == '30_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }

        $salesData = $query->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $salesData->pluck('date')->toArray(),
            'values' => $salesData->pluck('total')->toArray()
        ];
    }

    private function getBestSellingProducts()
    {
        return Product::select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    }

    private function getTopCustomers()
    {
        return User::select('users.name', DB::raw('SUM(orders.total_price) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', 'delivered')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();
    }

    public function updatedFilter()
    {
        $this->updateDashboard();
    }

    private function getRevenuePerCategory()
    {
        return DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->select('categories.name', DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->get();
    }

    private function getAverageOrderValue()
    {
        $totalRevenue = Order::where('status', 'delivered')->sum('total_price');
        $totalOrders = Order::where('status', 'delivered')->count();
        
        return $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
    }


    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
