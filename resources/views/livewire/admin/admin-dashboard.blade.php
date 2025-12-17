<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h1>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Pendapatan Hari Ini</h3>
            <p class="text-2xl font-bold">Rp {{ number_format($dailyRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Pesanan Hari Ini</h3>
            <p class="text-2xl font-bold">{{ $dailyOrders }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Total Pelanggan</h3>
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Total Produk</h3>
            <p class="text-2xl font-bold">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Retur Tertunda</h3>
            <p class="text-2xl font-bold">{{ $pendingReturns }}</p>
        </div>
    </div>
    
    {{-- Quick Links & Sales Chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-4">Grafik Penjualan (7 Hari Terakhir)</h3>
            <canvas id="salesChart"></canvas>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-4">Akses Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.orders') }}" class="block bg-blue-500 text-white text-center py-3 rounded-lg hover:bg-blue-600 transition">Kelola Pesanan</a>
                <a href="{{ route('admin.products') }}" class="block bg-green-500 text-white text-center py-3 rounded-lg hover:bg-green-600 transition">Kelola Produk</a>
                <a href="{{ route('admin.order-returns') }}" class="block bg-yellow-500 text-white text-center py-3 rounded-lg hover:bg-yellow-600 transition">Kelola Retur</a>
                <a href="{{ route('admin.reports') }}" class="block bg-purple-500 text-white text-center py-3 rounded-lg hover:bg-purple-600 transition">Lihat Laporan</a>
            </div>
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="font-bold text-lg mb-4">Pesanan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                    @if($order->status == 'paid') bg-green-100 text-green-800 @endif
                                    @if($order->status == 'delivered') bg-blue-100 text-blue-800 @endif
                                    @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada pesanan terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($chartData['values']),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush
