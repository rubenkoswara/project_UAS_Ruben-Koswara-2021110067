<div class="p-6">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pengelolaan Retur Pesanan</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua pengajuan retur pesanan dan tentukan statusnya di sini.</p>
    </div>

    <div class="bg-white border rounded-xl shadow p-4 mb-6">
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse($returns as $return)
                <div class="bg-white border rounded-xl shadow hover:shadow-xl transition p-5 relative">
                    <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-semibold
                        @if($return->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($return->status === 'reviewed') bg-blue-100 text-blue-800
                        @elseif($return->status === 'shipped') bg-purple-100 text-purple-800
                        @elseif($return->status === 'received') bg-green-100 text-green-800
                        @elseif($return->status === 'rejected_by_admin') bg-red-100 text-red-800
                        @endif">{{ ucfirst($return->status) }}</span>

                    <p class="font-semibold text-lg mb-1">#{{ $return->id }} - {{ $return->order->user->name }}</p>
                    <p class="text-gray-600 mb-2">{{ $return->orderItem->product->name }} (Qty: {{ $return->orderItem->quantity }})</p>
                    <p class="text-gray-500 text-sm mb-3 truncate">{{ $return->reason }}</p>

                    <button wire:click="selectReturn({{ $return->id }})" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg py-2">
                        Detail Retur
                    </button>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center mt-10">Belum ada pengajuan retur.</p>
            @endforelse
        </div>
    </div>

    @if($selectedReturn)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50">
            <div class="bg-white w-full max-w-3xl p-6 rounded-xl shadow-lg max-h-[90vh] overflow-y-auto">
                <button wire:click="closeModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>

                <h2 class="text-xl font-bold mb-4 text-gray-800">
                    Detail Retur #{{ $selectedReturn->id }}
                </h2>

                <div class="p-6 space-y-6">

                    @if($toastMessage)
                        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                            {{ $toastMessage }}
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <p><strong>Customer:</strong> {{ $selectedReturn->order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $selectedReturn->order->user->email }}</p>
                            <p><strong>No. Telepon:</strong> {{ $selectedReturn->order->user->phone ?? '-' }}</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Produk:</strong> {{ $selectedReturn->orderItem->product->name }}</p>
                            <p><strong>Qty:</strong> {{ $selectedReturn->orderItem->quantity }}</p>
                            <p><strong>Total Harga:</strong> Rp {{ number_format($selectedReturn->order->total,0,',','.') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="font-semibold">Alasan Retur:</p>
                        <p class="text-gray-600">{{ $selectedReturn->reason }}</p>
                    </div>

                    @if($selectedReturn->status === 'rejected_by_admin' && $selectedReturn->review_reason)
                        <div class="p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg mt-4">
                            <p class="font-semibold text-red-800">Alasan Penolakan Admin:</p>
                            <p class="text-red-700">{{ $selectedReturn->review_reason }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="font-semibold">Bukti Barang Customer:</p>
                        @if($selectedReturn->item_proof)
                            @php $ext = strtolower(pathinfo($selectedReturn->item_proof, PATHINFO_EXTENSION)); $isImg = in_array($ext,['jpg','jpeg','png']); @endphp
                            @if($isImg)
                                <img src="{{ asset('storage/'.$selectedReturn->item_proof) }}" class="w-full rounded-xl object-contain shadow mb-2">
                            @else
                                <iframe src="{{ asset('storage/'.$selectedReturn->item_proof) }}" class="w-full h-64 rounded-xl border mb-2"></iframe>
                            @endif
                        @else
                            <p class="text-gray-500">Belum ada bukti barang</p>
                        @endif
                    </div>

                    @if($selectedReturn->shipment_proof)
                        <div>
                            <p class="font-semibold">Bukti Resi Customer:</p>
                            @php $ext2 = strtolower(pathinfo($selectedReturn->shipment_proof, PATHINFO_EXTENSION)); $isImg2 = in_array($ext2,['jpg','jpeg','png']); @endphp
                            @if($isImg2)
                                <img src="{{ asset('storage/'.$selectedReturn->shipment_proof) }}" class="w-full rounded-xl object-contain shadow mb-2">
                            @else
                                <iframe src="{{ asset('storage/'.$selectedReturn->shipment_proof) }}" class="w-full h-64 rounded-xl border mb-2"></iframe>
                            @endif
                        </div>
                    @endif

                    @if($selectedReturn->status === 'pending')
                        <div class="flex gap-2 mt-4">
                            <button wire:click="approveReturn" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">Setujui</button>
                            <input type="text" wire:model="rejectReason" placeholder="Alasan tolak" class="border-gray-300 p-2 rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm flex-1">
                            <button wire:click="rejectReturn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">Tolak</button>
                        </div>
                    @elseif($selectedReturn->status === 'shipped')
                        <div class="flex gap-2 mt-4 items-center">
                            <button wire:click="confirmReceived" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">Terima Barang</button>
                            <input type="text" wire:model="rejectReason" placeholder="Alasan tolak barang" class="border-gray-300 p-2 rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm flex-1">
                            <button wire:click="rejectReturn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">Tolak Barang</button>
                        </div>
                    @elseif($selectedReturn->status === 'received')
                        <div class="mt-4">
                            <p class="font-semibold mb-2">Upload Bukti Refund:</p>
                            <input type="file" wire:model="refundProof" class="mt-1 border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm mb-2">
                            <button wire:click="uploadRefundProof" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">Upload</button>
                        </div>
                    @endif

                </div>

                <div class="mt-5 flex justify-end gap-2">
                    <button wire:click="closeModal" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">Tutup</button>
                </div>
            </div>
        </div>
    @endif

</div>
