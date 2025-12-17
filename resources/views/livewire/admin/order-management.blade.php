<div class="p-6">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Pesanan</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua pesanan, status, dan detail pengiriman di sini.</p>
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 text-green-800 border border-green-300 p-3 rounded-lg mb-4 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    {{-- FILTER --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6 border border-gray-200">
        <div class="flex flex-wrap gap-4 items-center">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                <select wire:model="searchStatus" class="border border-gray-300 p-2 rounded-lg shadow-sm bg-white">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Diproses</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="canceled">Dibatalkan</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" wire:model="searchDate" class="border border-gray-300 p-2 rounded-lg shadow-sm bg-white">
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border rounded-xl shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $order->id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $order->user->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-800">Rp {{ number_format($order->total,0,',','.') }}</td>

                    <td class="px-4 py-3 capitalize">
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'processing' => 'bg-blue-100 text-blue-700',
                                'dikirim' => 'bg-indigo-100 text-indigo-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'canceled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-lg text-sm font-medium {{ $colors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $order->status }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-800">{{ $order->created_at->format('d/m/Y H:i') }}</td>

                    <td class="px-4 py-3 text-center">
                        <button wire:click="selectOrder({{ $order->id }})"
                                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow text-xs">
                            Detail & Update
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- MODAL --}}
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
                        @php
                            $ext = strtolower(pathinfo($selectedOrder->payment_proof, PATHINFO_EXTENSION));
                            $isImg = in_array($ext, ['jpg','jpeg','png']);
                        @endphp
                        @if($isImg)
                            <a href="{{ asset('storage/'.$selectedOrder->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/'.$selectedOrder->payment_proof) }}" alt="Bukti Pembayaran" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                            </a>
                        @else
                            <a href="{{ asset('storage/'.$selectedOrder->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline">Lihat PDF</a>
                        @endif
                    @else
                        <p class="text-gray-500 text-sm p-4 bg-gray-50 rounded-lg">Tidak ada</p>
                    @endif
                </div>
                <div>
                    <h4 class="font-semibold text-sm mb-2">Resi Pengiriman</h4>
                    @if($selectedOrder->receipt)
                        <a href="{{ asset('storage/'.$selectedOrder->receipt) }}" target="_blank">
                            <img src="{{ asset('storage/' . $selectedOrder->receipt) }}" alt="Resi" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                        </a>
                    @else
                        <p class="text-gray-500 text-sm p-4 bg-gray-50 rounded-lg">Tidak ada</p>
                    @endif
                </div>
                <div>
                    <h4 class="font-semibold text-sm mb-2">Bukti Pengiriman</h4>
                     @if($selectedOrder->delivery_proof)
                        <a href="{{ asset('storage/'.$selectedOrder->delivery_proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $selectedOrder->delivery_proof) }}" alt="Bukti Pengiriman" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                        </a>
                    @else
                        <p class="text-gray-500 text-sm p-4 bg-gray-50 rounded-lg">Tidak ada</p>
                    @endif
                </div>
            </div>

            {{-- STATUS --}}
            <div class="mt-8 p-5 border rounded-2xl bg-gray-50 shadow-sm">
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Update Status</h4>
                <select wire:model="newStatus"
                    class="border border-gray-300 p-2 w-full rounded-lg focus:ring-2 focus:ring-blue-300">
                    <option value="pending">Pending</option>
                    <option value="processing">Diproses</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="canceled">Dibatalkan</option>
                </select>

                <div class="mt-4">
                    <label class="font-semibold block mb-1">Upload Resi (Opsional)</label>
                    <input type="file" wire:model="resi" class="w-full border border-gray-300 p-2 rounded-lg">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-8">
                <button wire:click="closeDetailModal" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">Batal</button>
                <button wire:click="updateStatus" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">Simpan</button>
            </div>
        </div>
    </div>
    @endif

</div>
