<div class="p-8 bg-gray-50 min-h-screen text-left relative">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
    </style>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Admin <span class="text-blue-600">Dashboard</span></h1>
            <p class="text-gray-500 text-sm font-medium mt-1">Selamat datang kembali, berikut ringkasan bisnis Anda hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-white border border-gray-100 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-400 shadow-sm">
                {{ now()->format('d F Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
        @php
            $stats = [
                ['label' => 'Pendapatan Hari Ini', 'value' => 'Rp ' . number_format($dailyRevenue, 0, ',', '.'), 'color' => 'blue', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.407 2.67 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.407-2.67-1M12 16v1'],
                ['label' => 'Pesanan Hari Ini', 'value' => $dailyOrders, 'color' => 'indigo', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                ['label' => 'Total Pelanggan', 'value' => $totalUsers, 'color' => 'emerald', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857'],
                ['label' => 'Total Produk', 'value' => $totalProducts, 'color' => 'amber', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['label' => 'Retur Tertunda', 'value' => $pendingReturns, 'color' => 'red', 'icon' => 'M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="w-12 h-12 bg-{{ $stat['color'] }}-50 rounded-2xl flex items-center justify-center text-{{ $stat['color'] }}-600 mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
            </div>
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $stat['label'] }}</h3>
            <p class="text-xl font-black text-gray-900 tracking-tight">{{ $stat['value'] }}</p>
        </div>
        @endforeach
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-black text-gray-900 uppercase text-xs tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span> Statistik Penjualan
                </h3>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">7 Hari Terakhir</span>
            </div>
            <div class="h-[320px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-white border border-gray-100 p-8 rounded-[2.5rem] shadow-sm flex flex-col justify-between">
            <h3 class="font-black text-gray-900 uppercase text-xs tracking-[0.2em] mb-6">Akses Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.orders') }}" class="flex items-center justify-between bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white p-5 rounded-2xl transition-all group border border-blue-100/50">
                    <span class="text-[10px] font-black uppercase tracking-widest">Kelola Pesanan</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('admin.products') }}" class="flex items-center justify-between bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white p-5 rounded-2xl transition-all group border border-emerald-100/50">
                    <span class="text-[10px] font-black uppercase tracking-widest">Update Produk</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('admin.order-returns') }}" class="flex items-center justify-between bg-orange-50 hover:bg-orange-600 text-orange-600 hover:text-white p-5 rounded-2xl transition-all group border border-orange-100/50">
                    <span class="text-[10px] font-black uppercase tracking-widest">Cek Retur</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden mb-10">
        <div class="p-8 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-black text-gray-900 uppercase text-xs tracking-widest">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders') }}" class="text-[10px] font-black text-blue-600 hover:underline uppercase tracking-widest">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto p-4">
            <table class="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr class="text-gray-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-bold text-gray-600">
                    @forelse ($recentOrders as $order)
                        <tr class="bg-gray-50/50 hover:bg-blue-50/50 transition duration-200 cursor-pointer" wire:click="showOrder({{ $order->id }})">
                            <td class="px-6 py-4 first:rounded-l-2xl text-blue-600">#{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest
                                    @if($order->status == 'pending') bg-amber-100 text-amber-600 
                                    @elseif($order->status == 'paid') bg-emerald-100 text-emerald-600 
                                    @elseif($order->status == 'delivered') bg-blue-100 text-blue-600 
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-600 
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 last:rounded-r-2xl text-right text-gray-400 font-medium">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-400 text-xs italic font-medium tracking-widest uppercase">Data pesanan tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($selectedOrder)
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center z-[100] p-4 animate-fade-in text-left">
        <div class="bg-white rounded-[3rem] w-full max-w-2xl overflow-hidden shadow-2xl relative border border-white">
            <div class="p-8 flex justify-between items-start border-b border-gray-50">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Detail <span class="text-blue-600">Pesanan</span></h2>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mt-1">Order ID: #{{ $selectedOrder->id }}</p>
                </div>
                <button wire:click="closeModal" class="p-3 bg-gray-50 rounded-2xl hover:bg-red-50 hover:text-red-600 transition group">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-8 space-y-6 overflow-y-auto max-h-[60vh]">
                <div class="grid grid-cols-2 gap-4 text-xs font-bold uppercase tracking-widest">
                    <div class="p-5 bg-gray-50 rounded-3xl border border-gray-100">
                        <span class="text-gray-400 block mb-1">Pelanggan</span>
                        <span class="text-gray-900">{{ $selectedOrder->user->name }}</span>
                    </div>
                    <div class="p-5 bg-gray-50 rounded-3xl border border-gray-100">
                        <span class="text-gray-400 block mb-1">Status</span>
                        <span class="text-blue-600">{{ $selectedOrder->status }}</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Item Pesanan</span>
                    @foreach($selectedOrder->items as $item)
                    <div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 font-black text-xs">
                                {{ $item->quantity }}x
                            </div>
                            <span class="text-sm font-black text-gray-800">{{ $item->product->name }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="bg-white border-2 border-blue-50 rounded-[2rem] p-6 text-gray-900 shadow-xl shadow-blue-100/50">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Total Pembayaran</span>
                        <span class="text-2xl font-black text-blue-600">Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="p-8 pt-0">
                <button wire:click="closeModal" class="w-full py-4 bg-gray-100 hover:bg-gray-200 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] transition text-gray-600 border border-gray-200/50">Tutup Detail</button>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        const initChart = () => {
            if (typeof Chart === 'undefined') {
                setTimeout(initChart, 100);
                return;
            }
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;
            const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($chartData['values']),
                        borderColor: '#3b82f6',
                        borderWidth: 4,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 3,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#f1f5f9' },
                            ticks: { font: {weight: 'bold'}, callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) }
                        },
                        x: { grid: { display: false }, ticks: { font: {weight: 'bold'} } }
                    }
                }
            });
        };
        initChart();
    });
</script>
@endpush