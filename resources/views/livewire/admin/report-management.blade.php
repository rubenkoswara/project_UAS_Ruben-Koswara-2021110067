<div class="p-6 space-y-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Laporan Penjualan</h1>
            <p class="text-sm text-slate-500 mt-1">Dashboard ringkasan performa penjualan lengkap.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <select wire:model="filterType" class="px-4 py-2.5 border rounded-xl bg-white shadow-sm text-sm">
                <option value="daily">Harian</option>
                <option value="weekly">Mingguan</option>
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
                <option value="custom">Periodik</option>
            </select>

            @if($filterType === 'daily')
                <input type="date" wire:model="selectedDate" class="px-4 py-2.5 border rounded-xl bg-white shadow-sm text-sm">
            @endif

            @if($filterType === 'weekly')
                <input type="week" wire:model="selectedWeek" class="px-4 py-2.5 border rounded-xl bg-white shadow-sm text-sm">
            @endif

            @if($filterType === 'monthly')
                <input type="month" wire:model="selectedMonth" class="px-4 py-2.5 border rounded-xl bg-white shadow-sm text-sm">
            @endif

            @if($filterType === 'yearly')
                <input type="number" wire:model="selectedYear" placeholder="Tahun" class="px-4 py-2.5 border rounded-xl bg-white shadow-sm text-sm w-28">
            @endif

            @if($filterType === 'custom')
                <input type="date" wire:model="startDate" class="px-4 py-2.5 border rounded-xl bg-white shadow-sm text-sm">
                <input type="date" wire:model="endDate" class="px-4 py-2.5 border rounded-xl bg-white shadow-sm text-sm">
            @endif

            <button wire:click="applyFilter" class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl shadow-sm text-sm hover:bg-indigo-700 transition">Filter</button>
            <button wire:click="exportCsv" class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl shadow-sm text-sm hover:bg-emerald-700 transition">CSV</button>
            <button wire:click="exportPdf" class="px-4 py-2.5 bg-rose-600 text-white rounded-xl shadow-sm text-sm hover:bg-rose-700 transition">PDF</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl border shadow-md p-6">
            <div class="text-sm text-slate-500">Total Revenue</div>
            <div class="mt-3 text-3xl font-bold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="text-xs text-slate-400 mt-2">Avg per order: Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</div>
        </div>

        <div class="bg-white rounded-2xl border shadow-md p-6">
            <div class="text-sm text-slate-500">Total Orders</div>
            <div class="mt-3 text-3xl font-bold text-slate-900">{{ $totalOrders }}</div>
            <div class="text-xs text-slate-400 mt-2">Periode terpilih</div>
        </div>

        <div class="bg-white rounded-2xl border shadow-md p-6">
            <div class="text-sm text-slate-500">Conversion</div>
            <div class="mt-3 text-3xl font-bold text-slate-900">—</div>
            <div class="text-xs text-slate-400 mt-2">Tambahkan metrik jika tersedia</div>
        </div>

        <div class="bg-white rounded-2xl border shadow-md p-6">
            <div class="text-sm text-slate-500">Period</div>
            <div class="mt-3 text-lg font-semibold text-slate-900">
                @if($startDate && $endDate)
                    {{ $startDate }} — {{ $endDate }}
                @else
                    {{ \Carbon\Carbon::today()->subDays(29)->toDateString() }} — {{ \Carbon\Carbon::today()->toDateString() }}
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-900">Grafik Penjualan</h2>
            <span class="text-sm text-slate-500">Pendapatan & Total Pesanan</span>
        </div>

        <canvas id="comboChart" class="mt-4" height="130"></canvas>
    </div>

    <div class="bg-white rounded-2xl border shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Daftar Pesanan</h2>
                <p class="text-sm text-slate-500">Pesanan berdasarkan periode filter</p>
            </div>
            <div class="text-sm text-slate-500">
                Showing {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-slate-100 text-xs text-slate-600 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Order</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-left">Payment</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    @forelse($orders as $o)
                        <tr wire:click="openDetailModal({{ $o->id }})" class="border-b hover:bg-slate-50 transition cursor-pointer">
                            <td class="px-4 py-3 font-medium">#{{ $o->id }}</td>
                            <td class="px-4 py-3">{{ $o->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($o->total,0,',','.') }}</td>
                            <td class="px-4 py-3">{{ $o->payment_method ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    @if($o->status === 'completed') bg-emerald-100 text-emerald-700
                                    @elseif(in_array($o->status, ['pending','created'])) bg-yellow-100 text-yellow-700
                                    @else bg-slate-200 text-slate-700 @endif">
                                    {{ ucfirst($o->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $o->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-slate-500" colspan="6">Tidak ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $orders->links() }}</div>
    </div>

    @if($showDetailModal && $selectedOrder)
    @php
        $shippingInfo = $selectedOrder->shipping_info ? json_decode($selectedOrder->shipping_info, true) : [];
    @endphp
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-4xl p-8 overflow-y-auto max-h-[90vh] shadow-2xl relative">
            <button wire:click="closeDetailModal" class="absolute top-5 right-5 text-gray-400 hover:text-gray-700 text-3xl">&times;</button>
            
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Detail Pesanan #{{ $selectedOrder->id }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 border-b pb-2">Informasi Customer</h3>
                    <p><span class="font-semibold">Nama:</span> {{ $selectedOrder->user->name ?? '-' }}</p>
                    <p><span class="font-semibold">Email:</span> {{ $selectedOrder->user->email ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 border-b pb-2">Informasi Pesanan</h3>
                    <p><span class="font-semibold">Tanggal:</span> {{ $selectedOrder->created_at->format('d M Y, H:i') }}</p>
                    <p><span class="font-semibold">Status:</span> 
                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                            @if($selectedOrder->status === 'completed') bg-emerald-100 text-emerald-700
                            @elseif(in_array($selectedOrder->status, ['pending','created'])) bg-yellow-100 text-yellow-700
                            @else bg-slate-200 text-slate-700 @endif">
                            {{ ucfirst($selectedOrder->status) }}
                        </span>
                    </p>
                    <p><span class="font-semibold">Metode Pembayaran:</span> {{ $selectedOrder->payment_method ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold text-gray-700 mb-2 border-b pb-2">Informasi Pengiriman</h3>
                    @if(!empty($shippingInfo))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 text-sm">
                            <p><span class="font-semibold">Alamat:</span> {{ $shippingInfo['alamat'] ?? '-' }}</p>
                            <p><span class="font-semibold">Kota:</span> {{ $shippingInfo['kota'] ?? '-' }}</p>
                            <p><span class="font-semibold">Kecamatan:</span> {{ $shippingInfo['kecamatan'] ?? '-' }}</p>
                            <p><span class="font-semibold">Kelurahan:</span> {{ $shippingInfo['kelurahan'] ?? '-' }}</p>
                            <p><span class="font-semibold">No. Telepon:</span> {{ $shippingInfo['no_telp'] ?? '-' }}</p>
                            <p><span class="font-semibold">Kurir:</span> {{ $shippingInfo['shipping'] ?? '-' }}</p>
                            <div class="sm:col-span-2"><span class="font-semibold">Catatan:</span> {{ $shippingInfo['note'] ?? '-' }}</div>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Tidak ada informasi pengiriman.</p>
                    @endif
                </div>
            </div>

            <h3 class="font-semibold text-gray-700 mb-3 border-b pb-2">Item Pesanan</h3>
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-3 font-semibold">Produk</th>
                            <th class="p-3 font-semibold text-center">Jumlah</th>
                            <th class="p-3 font-semibold text-right">Harga</th>
                            <th class="p-3 font-semibold text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedOrder->orderItems as $item)
                        <tr class="border-b">
                            <td class="p-3">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="p-3 text-center">{{ $item->quantity }}</td>
                            <td class="p-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="p-3 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-end items-center mb-6">
                <div class="text-right">
                    <p class="text-gray-600">Subtotal: <span class="font-semibold">Rp {{ number_format($selectedOrder->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span></p>
                    <p class="text-gray-600">Ongkir: <span class="font-semibold">Rp {{ number_format($shippingInfo['shipping_cost'] ?? 0, 0, ',', '.') }}</span></p>
                    <p class="text-xl font-bold text-gray-800 mt-2">Total: <span class="text-indigo-600">Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</span></p>
                </div>
            </div>

            <h3 class="font-semibold text-gray-700 mb-3 border-b pb-2">Bukti Pendukung</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div>
                    <h4 class="font-semibold text-sm mb-2">Bukti Pembayaran</h4>
                    @if($selectedOrder->payment_proof)
                        <img src="{{ asset('storage/' . $selectedOrder->payment_proof) }}" alt="Bukti Pembayaran" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                    @else
                        <p class="text-gray-500 text-sm p-4 bg-gray-50 rounded-lg">Tidak ada</p>
                    @endif
                </div>
                <div>
                    <h4 class="font-semibold text-sm mb-2">Resi Pengiriman</h4>
                    @if($selectedOrder->receipt)
                        <img src="{{ asset('storage/' . $selectedOrder->receipt) }}" alt="Resi" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                    @else
                        <p class="text-gray-500 text-sm p-4 bg-gray-50 rounded-lg">Tidak ada</p>
                    @endif
                </div>
                <div>
                    <h4 class="font-semibold text-sm mb-2">Bukti Pengiriman</h4>
                     @if($selectedOrder->delivery_proof)
                        <img src="{{ asset('storage/' . $selectedOrder->delivery_proof) }}" alt="Bukti Pengiriman" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                    @else
                        <p class="text-gray-500 text-sm p-4 bg-gray-50 rounded-lg">Tidak ada</p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button wire:click="closeDetailModal" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">Tutup</button>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

<script>
    let ctx = document.getElementById('comboChart').getContext('2d');

    let comboChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    type: 'bar',
                    label: 'Total Pesanan',
                    data: @json($chartOrderCount),
                    backgroundColor: 'rgba(79,70,229,0.85)',
                    borderRadius: 8,
                    yAxisID: 'y',
                },
                {
                    type: 'line',
                    label: 'Pendapatan',
                    data: @json($chartIncome),
                    borderWidth: 3,
                    pointRadius: 4,
                    tension: 0.35,
                    fill: true,
                    borderColor: 'rgba(16,185,129,1)',
                    backgroundColor: 'rgba(16,185,129,0.15)',
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { labels: { font: { size: 12 } } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.dataset.type === 'line')
                                return 'Rp ' + Number(context.parsed.y).toLocaleString();
                            return context.dataset.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 }},
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { callback: v => 'Rp ' + Number(v).toLocaleString() }
                }
            }
        }
    });

    Livewire.hook('message.processed', () => {
        comboChart.data.labels = @json($chartLabels);
        comboChart.data.datasets[0].data = @json($chartOrderCount);
        comboChart.data.datasets[1].data = @json($chartIncome);
        comboChart.update();
    });
</script>
@endpush
