<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>


    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-500 text-white p-6 rounded shadow">
            <h3 class="text-xl font-bold">Total Users</h3>
            <p class="text-3xl">{{ $totalUsers }}</p>
        </div>

        <div class="bg-green-500 text-white p-6 rounded shadow">
            <h3 class="text-xl font-bold">Total Orders</h3>
            <p class="text-3xl">{{ $totalOrders }}</p>
        </div>

        <div class="bg-yellow-500 text-white p-6 rounded shadow">
            <h3 class="text-xl font-bold">Total Sales</h3>
            <p class="text-3xl">${{ number_format($totalSales, 2) }}</p>
        </div>
    </div>

    <!-- Sales Trends Chart with Filtering -->
    {{-- <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between mb-4">
            <h3 class="text-xl font-bold">Sales Trends</h3>
            <select wire:model="filter" class="border p-2 rounded">
                <option value="7_days">Last 7 Days</option>
                <option value="30_days">Last 30 Days</option>
                <option value="all_time">All Time</option>
            </select>
        </div>
        <canvas id="salesChart"></canvas>
    </div> --}}

    <!-- Best-Selling Products -->
    <div class="bg-white p-6 rounded shadow mt-6">
        <h3 class="text-xl font-bold mb-4">Best-Selling Products</h3>
        <ul>
            @foreach ($bestSellingProducts as $product)
                <li class="flex justify-between border-b py-2">
                    <span>{{ $product->name }}</span>
                    <span class="font-bold">{{ $product->total_sold }} Sold</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Top Customers -->
    <div class="bg-white p-6 rounded shadow mt-6">
        <h3 class="text-xl font-bold mb-4">Top Customers</h3>
        <ul>
            @foreach ($topCustomers as $customer)
                <li class="flex justify-between border-b py-2">
                    <span>{{ $customer->name }}</span>
                    <span class="font-bold">${{ number_format($customer->total_spent, 2) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-yellow-500 text-white p-6 rounded shadow">
            <h3 class="text-xl font-bold">Average Order Value</h3>
            <p class="text-3xl">${{ number_format($averageOrderValue, 2) }}</p>
        </div>
    </div>
    
    <!-- Revenue Per Category -->
    <div class="bg-white p-6 rounded shadow mt-6">
        <h3 class="text-xl font-bold mb-4">Revenue Per Category</h3>
        <ul>
            @foreach ($revenuePerCategory as $category)
                <li class="flex justify-between border-b py-2">
                    <span>{{ $category->name }}</span>
                    <span class="font-bold">${{ number_format($category->total_revenue, 2) }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-xl font-bold mb-4">Filter Reports by Date</h3>
        <div class="flex space-x-4">
            <input type="date" wire:model="startDate" class="border p-2 rounded">
            <input type="date" wire:model="endDate" class="border p-2 rounded">
            <button wire:click="updateDashboard" class="bg-blue-500 text-white px-4 py-2 rounded">Apply</button>
        </div>
    </div>

    <!-- Daily Revenue -->
    {{-- <div class="bg-white p-6 rounded shadow mt-6">
        <h3 class="text-xl font-bold mb-4">Daily Revenue (Last 7 Days)</h3>
        <ul>
            @foreach ($dailyRevenue as $day)
                <li class="flex justify-between border-b py-2">
                    <span>{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</span>
                    <span class="font-bold">${{ number_format($day->total_revenue, 2) }}</span>
                </li>
            @endforeach
        </ul>
    </div> --}}

    <!-- Customer Order Frequency -->
    <div class="bg-white p-6 rounded shadow mt-6">
        <h3 class="text-xl font-bold mb-4">Top Customers (Order Frequency)</h3>
        <ul>
            @foreach ($customerOrderFrequency as $customer)
                <li class="flex justify-between border-b py-2">
                    <span>{{ $customer->name }}</span>
                    <span class="font-bold">{{ $customer->total_orders }} orders</span>
                </li>
            @endforeach
        </ul>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        let ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($salesChart['labels']),
                datasets: [{
                    label: 'Total Sales ($)',
                    data: @json($salesChart['values']),
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
