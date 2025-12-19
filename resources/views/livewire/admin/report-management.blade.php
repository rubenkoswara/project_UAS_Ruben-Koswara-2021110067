<div class="p-6 bg-[#f8fafc] min-h-screen space-y-6">
    <div class="relative z-[60] grid grid-cols-1 lg:grid-cols-3 gap-4 items-center bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm">
    <div class="lg:col-span-1 px-2">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Laporan Penjualan</h1>
        <p class="text-sm text-slate-500 font-medium">Dashboard ringkasan performa penjualan.</p>
    </div>

    <div class="lg:col-span-2 flex flex-wrap items-center justify-end gap-3">
        <div class="flex flex-wrap items-center gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-100 overflow-visible relative">
            <select wire:model="filterType" class="px-3 py-2 border-none bg-transparent text-sm focus:ring-0 cursor-pointer appearance-none pr-8 rounded-xl hover:bg-slate-200/50 transition">
                <option value="daily">Harian</option>
                <option value="weekly">Mingguan</option>
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
                <option value="custom">Periodik</option>
            </select>

            @if($filterType === 'daily')
                <input type="date" wire:model="selectedDate" class="bg-white border-slate-200 rounded-xl text-xs py-1.5 focus:ring-indigo-500 z-50">
            @endif
            @if($filterType === 'weekly')
                <input type="week" wire:model="selectedWeek" class="bg-white border-slate-200 rounded-xl text-xs py-1.5 focus:ring-indigo-500 z-50">
            @endif
            @if($filterType === 'monthly')
                <input type="month" wire:model="selectedMonth" class="bg-white border-slate-200 rounded-xl text-xs py-1.5 focus:ring-indigo-500 z-50">
            @endif
            @if($filterType === 'yearly')
                <input type="number" wire:model="selectedYear" placeholder="Tahun" class="bg-white border-slate-200 rounded-xl text-xs py-1.5 w-24 focus:ring-indigo-500 z-50">
            @endif
            @if($filterType === 'custom')
                <div class="flex items-center gap-1 overflow-visible">
                    <input type="date" wire:model="startDate" class="bg-white border-slate-200 rounded-xl text-xs py-1.5 focus:ring-indigo-500 z-50">
                    <input type="date" wire:model="endDate" class="bg-white border-slate-200 rounded-xl text-xs py-1.5 focus:ring-indigo-500 z-50">
                </div>
            @endif
        </div>

        <div class="flex gap-2">
            <button wire:click="applyFilter" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 uppercase tracking-wider">Filter</button>
            <button wire:click="exportCsv" class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-100 transition border border-emerald-100">CSV</button>
            <button wire:click="exportPdf" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition border border-rose-100">PDF</button>
        </div>
    </div>
</div>

    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-6">
        
        <div class="md:col-span-2 lg:col-span-2 bg-indigo-600 rounded-[2.5rem] p-8 text-white flex flex-col justify-between shadow-xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-indigo-100 text-xs font-black uppercase tracking-[0.2em]">Total Revenue</p>
                <h2 class="text-4xl font-black mt-4">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            </div>
            <div class="mt-10 relative z-10">
                <p class="text-indigo-200 text-[10px] uppercase font-bold tracking-widest">Avg per order</p>
                <p class="text-xl font-bold">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="md:col-span-2 lg:col-span-2 bg-white rounded-[2.5rem] p-8 border border-slate-200 flex flex-col items-center justify-center text-center shadow-sm">
            <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-[1.5rem] flex items-center justify-center mb-4 border border-orange-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em]">Total Orders</p>
            <h2 class="text-4xl font-black text-slate-900 mt-2">{{ $totalOrders }}</h2>
            <p class="text-slate-400 text-[10px] mt-1 font-bold uppercase tracking-tighter">Periode terpilih</p>
        </div>

        <div class="md:col-span-2 lg:col-span-2 bg-slate-900 rounded-[2.5rem] p-8 text-white flex flex-col justify-between shadow-xl shadow-slate-200">
            <div class="flex justify-between items-center">
                <span class="text-slate-400 text-xs font-black uppercase tracking-[0.2em]">Active Period</span>
                <div class="px-3 py-1 bg-white/10 rounded-full text-[10px] font-bold text-emerald-400">LIVE</div>
            </div>
            <div class="mt-6">
                <h2 class="text-xl font-bold leading-tight">
                    @if($startDate && $endDate)
                        {{ $startDate }} <span class="text-slate-500 mx-2">—</span> {{ $endDate }}
                    @else
                        {{ \Carbon\Carbon::today()->subDays(29)->toDateString() }} <span class="text-slate-500 mx-2">—</span> Now
                    @endif
                </h2>
            </div>
        </div>

        <div class="md:col-span-4 lg:col-span-6 bg-white rounded-[2.5rem] p-10 border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Grafik Penjualan</h2>
                    <p class="text-slate-500 text-sm font-medium">Pendapatan & Total Pesanan</p>
                </div>
                <div class="flex items-center gap-6 bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 bg-indigo-500 rounded-full shadow-[0_0_8px_rgba(79,70,229,0.5)]"></span><span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Pesanan</span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span><span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Pendapatan</span></div>
                </div>
            </div>
            <div class="relative w-full">
                <canvas id="comboChart" height="120"></canvas>
            </div>
        </div>

        <div class="md:col-span-4 lg:col-span-6 bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Pesanan</h2>
                    <p class="text-slate-400 text-sm font-medium">Data pesanan berdasarkan filter periode</p>
                </div>
                <div class="text-[10px] font-black text-slate-500 bg-slate-100 px-5 py-2.5 rounded-full border border-slate-100 uppercase tracking-widest">
                    Showing {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-5">Order</th>
                            <th class="px-4 py-5">Customer</th>
                            <th class="px-4 py-5 text-right">Total</th>
                            <th class="px-4 py-5 text-center">Payment</th>
                            <th class="px-4 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($orders as $o)
                        <tr wire:click="openDetailModal({{ $o->id }})" class="hover:bg-indigo-50/30 transition-all cursor-pointer group">
                            <td class="px-8 py-5 font-bold text-slate-900 group-hover:text-indigo-600">#{{ $o->id }}</td>
                            <td class="px-4 py-5 text-slate-600 font-medium">{{ $o->user->name ?? '-' }}</td>
                            <td class="px-4 py-5 text-right font-black text-slate-900">Rp {{ number_format($o->total,0,',','.') }}</td>
                            <td class="px-4 py-5 text-center text-slate-500 text-xs font-bold">{{ $o->payment_method ?? '-' }}</td>
                            <td class="px-4 py-5 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                    @if($o->status === 'completed') bg-emerald-100 text-emerald-700
                                    @elseif(in_array($o->status, ['pending','created'])) bg-amber-100 text-amber-700
                                    @else bg-slate-200 text-slate-700 @endif">
                                    {{ $o->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right text-slate-400 font-bold text-xs">{{ $o->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-8 py-16 text-center text-slate-400 font-medium" colspan="6">Tidak ada pesanan yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-8 bg-slate-50/50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    @if($showDetailModal && $selectedOrder)
    @php
        $shippingInfo = $selectedOrder->shipping_info ? json_decode($selectedOrder->shipping_info, true) : [];
    @endphp
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[3rem] w-full max-w-4xl p-8 lg:p-12 overflow-y-auto max-h-[90vh] shadow-2xl relative border border-slate-200">
            <button wire:click="closeDetailModal" class="absolute top-8 right-8 text-slate-400 hover:text-slate-900 transition text-4xl font-light">&times;</button>
            
            <div class="mb-10">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">Detail Pesanan #{{ $selectedOrder->id }}</h2>
                <p class="text-slate-500 font-medium mt-1">Review data transaksi dan bukti pendukung.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Informasi Customer</h3>
                    <div class="space-y-1">
                        <p class="text-lg font-bold text-slate-900">{{ $selectedOrder->user->name ?? '-' }}</p>
                        <p class="text-sm text-slate-500">{{ $selectedOrder->user->email ?? '-' }}</p>
                    </div>
                </div>

                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Informasi Pesanan</h3>
                    <div class="space-y-2 text-sm">
                        <p class="font-bold text-slate-900">Tanggal: <span class="font-medium text-slate-500">{{ $selectedOrder->created_at->format('d M Y, H:i') }}</span></p>
                        <p class="font-bold text-slate-900">Pembayaran: <span class="font-medium text-slate-500">{{ $selectedOrder->payment_method ?? '-' }}</span></p>
                        <div class="pt-2">
                            <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                @if($selectedOrder->status === 'completed') bg-emerald-100 text-emerald-700
                                @elseif(in_array($selectedOrder->status, ['pending','created'])) bg-amber-100 text-amber-700
                                @else bg-slate-200 text-slate-700 @endif">
                                {{ $selectedOrder->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Informasi Pengiriman</h3>
                    @if(!empty($shippingInfo))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm text-slate-600">
                            <div class="sm:col-span-2"><span class="font-bold text-slate-900">Alamat:</span> {{ $shippingInfo['alamat'] ?? '-' }}</div>
                            <div><span class="font-bold text-slate-900">Kelurahan:</span> {{ $shippingInfo['kelurahan'] ?? '-' }}</div>
                            <div><span class="font-bold text-slate-900">Kecamatan:</span> {{ $shippingInfo['kecamatan'] ?? '-' }}</div>
                            <div><span class="font-bold text-slate-900">Kota:</span> {{ $shippingInfo['kota'] ?? '-' }}</div>
                            <div><span class="font-bold text-slate-900">Kurir:</span> {{ $shippingInfo['shipping'] ?? '-' }}</div>
                            <div><span class="font-bold text-slate-900">No. Telp:</span> {{ $shippingInfo['no_telp'] ?? '-' }}</div>
                            <div class="sm:col-span-2 bg-white/50 p-4 rounded-xl italic border border-slate-100">
                                <span class="font-bold text-slate-900 not-italic">Catatan:</span> {{ $shippingInfo['note'] ?? '-' }}
                            </div>
                        </div>
                    @else
                        <p class="text-slate-400 text-sm italic">Tidak ada informasi pengiriman.</p>
                    @endif
                </div>
            </div>

            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-4">Item Pesanan</h3>
            <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden mb-8 shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-[10px] font-black uppercase text-slate-400">
                        <tr>
                            <th class="p-5">Produk</th>
                            <th class="p-5 text-center">Jumlah</th>
                            <th class="p-5 text-right">Harga</th>
                            <th class="p-5 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($selectedOrder->orderItems as $item)
                        <tr>
                            <td class="p-5 font-bold text-slate-900">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="p-5 text-center text-slate-500 font-bold">{{ $item->quantity }}</td>
                            <td class="p-5 text-right text-slate-500 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="p-5 text-right font-black text-indigo-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-end mb-12 px-6">
                <div class="text-right space-y-1">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Grand Total</p>
                    <p class="text-4xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</p>
                    <div class="flex justify-end gap-4 text-[11px] font-bold text-slate-500 pt-2">
                        <span>Subtotal: Rp {{ number_format($selectedOrder->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                        <span>Ongkir: Rp {{ number_format($shippingInfo['shipping_cost'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 ml-4">Bukti Pendukung</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="space-y-3">
                    <p class="text-center text-[10px] font-black uppercase text-slate-400 tracking-widest">Bukti Pembayaran</p>
                    <div class="aspect-square bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden hover:border-indigo-300 transition-colors group">
                        @if($selectedOrder->payment_proof)
                            <img src="{{ asset('storage/' . $selectedOrder->payment_proof) }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        @else
                            <span class="text-slate-300 font-bold italic text-xs">Tidak ada file</span>
                        @endif
                    </div>
                </div>
                <div class="space-y-3">
                    <p class="text-center text-[10px] font-black uppercase text-slate-400 tracking-widest">Resi Pengiriman</p>
                    <div class="aspect-square bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden hover:border-indigo-300 transition-colors group">
                        @if($selectedOrder->receipt)
                            <img src="{{ asset('storage/' . $selectedOrder->receipt) }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        @else
                            <span class="text-slate-300 font-bold italic text-xs">Tidak ada file</span>
                        @endif
                    </div>
                </div>
                <div class="space-y-3">
                    <p class="text-center text-[10px] font-black uppercase text-slate-400 tracking-widest">Bukti Pengiriman</p>
                    <div class="aspect-square bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden hover:border-indigo-300 transition-colors group">
                        @if($selectedOrder->delivery_proof)
                            <img src="{{ asset('storage/' . $selectedOrder->delivery_proof) }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        @else
                            <span class="text-slate-300 font-bold italic text-xs">Tidak ada file</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-center border-t border-slate-100 pt-10">
                <button wire:click="closeDetailModal" class="px-12 py-4 bg-slate-900 text-white rounded-[1.5rem] font-black uppercase tracking-[0.2em] text-xs hover:bg-slate-800 transition shadow-xl shadow-slate-200">Tutup Laporan</button>
            </div>
        </div>
    </div>
        @endif
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            const ctx = document.getElementById('comboChart');
            if (!ctx) return;
    
            let chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        type: 'line',
                        label: 'Pendapatan',
                        data: @json($chartIncome),
                        borderColor: 'rgb(16,185,129)',
                        backgroundColor: 'rgba(16,185,129,0.2)',
                        yAxisID: 'y1',
                        tension: 0.4,
                        fill: true,
                    }, {
                        type: 'bar',
                        label: 'Pesanan',
                        data: @json($chartOrderCount),
                        backgroundColor: 'rgb(79, 70, 229)',
                        borderColor: 'rgb(79, 70, 229)',
                        yAxisID: 'y',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            type: 'linear',
                            position: 'left',
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            type: 'linear',
                            position: 'right',
                            grid: {
                                drawOnChartArea: false, 
                            },
                        }
                    }
                }
            });
    
            Livewire.on('reportUpdated', (event) => {
                const newChartData = event[0];
                if (chart && newChartData) {
                    chart.data.labels = newChartData.labels;
                    chart.data.datasets[0].data = newChartData.income;
                    chart.data.datasets[1].data = newChartData.orderCount;
                    chart.update();
                }
            });
        });
    </script>
    @endpush
    