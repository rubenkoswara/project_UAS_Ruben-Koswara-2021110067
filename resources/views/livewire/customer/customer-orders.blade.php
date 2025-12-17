<div class="p-6 min-h-screen bg-gray-100">
    <h2 class="text-3xl font-bold mb-6">Daftar Pesanan</h2>

    <div class="flex flex-wrap gap-4 mb-6 items-center">
        <label class="text-gray-700 font-medium">Filter Status</label>
        <select wire:model="searchStatus" class="border p-2 rounded-lg">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="completed">Completed</option>
            <option value="canceled">Canceled</option>
            <option value="returned">Returned</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($orders as $order)
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-2xl transition">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-gray-700">#{{ $order->id }}</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'canceled') bg-red-100 text-red-800
                        @elseif($order->status === 'returned') bg-gray-200 text-gray-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <p class="text-gray-600 mb-2">Total:
                    <span class="font-semibold">Rp {{ number_format($order->total,0,',','.') }}</span>
                </p>
                <p class="text-gray-500 text-sm mb-4">Tanggal:
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </p>

                <button wire:click="selectOrder({{ $order->id }})"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Detail Pesanan
                </button>
            </div>
        @empty
            <p class="text-gray-500 col-span-full">Belum ada pesanan.</p>
        @endforelse
    </div>

    @if($selectedOrder)
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-xl font-bold text-gray-800">Detail Order #{{ $selectedOrder->id }}</h3>
                <button wire:click="closeModal" class="text-gray-500 hover:text-black text-2xl">&times;</button>
            </div>

            <div class="p-6 space-y-6">
                @if(session()->has('toast'))
                    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-4">
                        {{ session('toast') }}
                    </div>
                @endif

                @php $ship = json_decode($selectedOrder->shipping_info, true); @endphp
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <h4 class="text-lg font-semibold mb-2">Informasi Pengiriman</h4>
                    <p>{{ $ship['alamat'] }}, {{ $ship['kelurahan'] }}, {{ $ship['kecamatan'] }}, {{ $ship['kota'] }}</p>
                    <p>Telp: {{ $ship['no_telp'] }}</p>
                    @if(!empty($ship['note']))
                        <p>Catatan: {{ $ship['note'] }}</p>
                    @endif
                    <p class="font-semibold mt-2">Jasa Kirim: {{ $ship['shipping'] }} – Rp {{ number_format($ship['shipping_cost'] ?? 0,0,',','.') }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border">
                    <h4 class="text-lg font-semibold mb-2">Metode Pembayaran</h4>
                    <p>{{ $selectedOrder->paymentMethod?->name ?? $selectedOrder->payment_method ?? 'Belum dipilih' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border">
                    <h4 class="text-lg font-semibold mb-2">Produk Dalam Pesanan</h4>
                    <div class="divide-y">
                        @foreach($selectedOrder->orderItems as $item)
                            <div class="flex justify-between py-3">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-500">Harga: Rp {{ number_format($item->price,0,',','.') }}</p>
                                </div>
                                <p class="font-semibold text-gray-800">Rp {{ number_format($item->price * $item->quantity,0,',','.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-3 mt-3 space-y-1">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format(collect($selectedOrder->orderItems)->sum(fn($i) => $i->price * $i->quantity),0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Ongkir</span>
                            <span>Rp {{ number_format($ship['shipping_cost'] ?? 0,0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg text-gray-900">
                            <span>Total Akhir</span>
                            <span>Rp {{ number_format($selectedOrder->total,0,',','.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border">
                    <h4 class="text-lg font-semibold mb-2">Bukti Transfer</h4>
                    @if($selectedOrder->payment_proof)
                        @php $ext = strtolower(pathinfo($selectedOrder->payment_proof, PATHINFO_EXTENSION)); $isImg = in_array($ext, ['jpg','jpeg','png']); @endphp
                        @if($isImg)
                            <img src="{{ asset('storage/'.$selectedOrder->payment_proof) }}" class="rounded-xl w-full object-contain mb-2">
                        @else
                            <iframe src="{{ asset('storage/'.$selectedOrder->payment_proof) }}" class="w-full h-64 rounded-xl border mb-2"></iframe>
                        @endif
                    @else
                        <p class="text-gray-600">Belum ada bukti transfer</p>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border">
                <h4 class="text-lg font-semibold mb-2">Bukti Pengiriman</h4>
                @if($selectedOrder->receipt)
                    @php
                        $ext = strtolower(pathinfo($selectedOrder->receipt, PATHINFO_EXTENSION));
                        $isImg = in_array($ext, ['jpg','jpeg','png']);
                    @endphp
                    @if($isImg)
                        <img src="{{ asset('storage/'.$selectedOrder->receipt) }}" class="rounded-xl w-full object-contain mb-2">
                    @else
                        <iframe src="{{ asset('storage/'.$selectedOrder->receipt) }}" class="w-full h-64 rounded-xl border mb-2"></iframe>
                    @endif
                @else
                    <p class="text-gray-600">Belum ada bukti pengiriman</p>
                @endif
</div>

                @if($selectedOrder->status === 'completed')
                <div class="bg-gray-50 p-4 rounded-xl border space-y-4">
                    <h4 class="text-lg font-semibold text-gray-700">Review & Retur Produk</h4>
                    @foreach($selectedOrder->orderItems as $item)
                        <div class="bg-white border rounded-xl p-4 mb-3">
                            <p class="font-medium text-gray-800 mb-2">{{ $item->product->name }}</p>

                            <input type="number" wire:model="rating.{{ $item->id }}" min="1" max="5" placeholder="Rating (1-5)" class="border p-2 rounded-lg w-full mb-2">
                            <textarea wire:model="comment.{{ $item->id }}" class="border p-2 rounded-lg w-full h-20 mb-2" placeholder="Tulis komentar..."></textarea>
                            <button wire:click="submitReview({{ $item->id }})" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 mb-2">Kirim Review</button>

                            <select wire:model="returnReason.{{ $item->id }}" class="border p-2 rounded-lg w-full mb-2">
                                <option value="">Pilih Alasan Retur</option>
                                <option value="Barang Tidak Sesuai">Barang Tidak Sesuai</option>
                                <option value="Barang Rusak">Barang Rusak</option>
                                <option value="Barang Hilang">Barang Hilang</option>
                            </select>
                            <input type="file" wire:model="returnProof.{{ $item->id }}" class="border p-2 rounded-lg w-full mb-2">
                            <button wire:click="submitReturn({{ $item->id }})" class="w-full bg-yellow-600 text-white py-2 rounded-lg hover:bg-yellow-700">Ajukan Retur</button>

                            @php $return = $selectedOrder->returns->firstWhere('order_item_id', $item->id) @endphp
                            @if($return)
                                @if($return->item_proof)
                                    <img src="{{ asset('storage/'.$return->item_proof) }}" class="w-full rounded-lg object-contain border max-h-64 mb-2">
                                @else
                                    <p class="text-gray-500">Belum ada foto barang retur</p>
                                @endif
                                <p class="text-gray-600">Status: {{ ucfirst($return->status) }}</p>
                                @if($return->resi)
                                    <img src="{{ asset('storage/'.$return->resi) }}" class="w-full rounded-lg object-contain border max-h-64 mb-2">
                                @endif
                                @if($return->admin_reason)
                                    <p class="text-gray-600">Alasan Admin: {{ $return->admin_reason }}</p>
                                @endif
                                @if($return->refund_proof)
                                    <img src="{{ asset('storage/'.$return->refund_proof) }}" class="w-full rounded-lg object-contain border max-h-64 mb-2">
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="border-t p-4 text-right">
                <button wire:click="closeModal" class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Tutup</button>
            </div>
        </div>
    </div>
    @endif
</div>
