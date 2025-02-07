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
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between mb-4">
            <h3 class="text-xl font-bold">Sales Trends</h3>
            <select wire:model="filter" class="border p-2 rounded">
                <option value="7_days">Last 7 Days</option>
                <option value="30_days">Last 30 Days</option>
                <option value="all_time">All Time</option>
            </select>
        </div>
        
        <canvas id="salesChart"></canvas>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart;

    function createChart(salesData) {
        var labels = salesData.map(data => data.date);
        var values = salesData.map(data => data.total);

        if (salesChart) {
            salesChart.destroy();
        }

        salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales ($)',
                    data: values,
                    borderColor: 'blue',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    window.addEventListener('updateChart', event => {
        createChart(event.detail.salesData);
    });
});
</script>
