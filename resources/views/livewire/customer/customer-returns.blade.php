<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Pengembalian Pesanan</h1>

    @if(session()->has('toast_success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-3">{{ session('toast_success') }}</div>
    @endif
    @if(session()->has('toast_error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-3">{{ session('toast_error') }}</div>
    @endif

    @if($returns->count())
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($returns as $return)
                <div class="bg-white shadow-lg rounded-xl p-6 border hover:shadow-2xl transition relative">
                    <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-semibold
                        @if($return->status === 'pending') bg-gray-200 text-gray-700
                        @elseif($return->status === 'reviewed') bg-blue-200 text-blue-800
                        @elseif($return->status === 'shipped') bg-green-200 text-green-800
                        @elseif($return->status === 'received') bg-purple-200 text-purple-800
                        @elseif(in_array($return->status, ['rejected','rejected_by_admin'])) bg-red-200 text-red-800
                        @endif">
                        {{ ucfirst($return->status) }}
                    </span>

                    <p class="text-lg font-semibold mb-1">Pesanan: #{{ $return->order->id }}</p>
                    <p class="text-gray-700 mb-2">Produk: {{ $return->orderItem->product->name }}</p>
                    <p class="text-gray-600 text-sm mb-4">{{ $return->reason }}</p>

                    <div class="flex justify-between items-center">
                        <button wire:click="openDetailModal({{ $return->id }})" 
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow">
                            Detail
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $returns->links() }}
        </div>
    @else
        <p class="text-gray-500 text-center text-lg mt-10">Belum ada pengajuan pengembalian.</p>
    @endif

    @if($showDetailModal && $selectedReturn)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl w-full max-w-xl p-6 overflow-y-auto max-h-[85vh] shadow-2xl relative">
                <button wire:click="closeDetailModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
                
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Detail Retur</h2>

                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Status:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($selectedReturn->status === 'pending') bg-gray-200 text-gray-700
                        @elseif($selectedReturn->status === 'reviewed') bg-blue-200 text-blue-800
                        @elseif($selectedReturn->status === 'shipped') bg-green-200 text-green-800
                        @elseif($selectedReturn->status === 'received') bg-purple-200 text-purple-800
                        @elseif(in_array($selectedReturn->status, ['rejected','rejected_by_admin'])) bg-red-200 text-red-800
                        @endif">
                        {{ ucfirst($selectedReturn->status) }}
                    </span>
                </div>

                <div class="mb-4">
                    <p class="font-semibold text-gray-700 mb-1">Alasan Retur:</p>
                    <p class="text-gray-600 mb-2">{{ $selectedReturn->reason }}</p>
                </div>

                @if($selectedReturn->status === 'rejected_by_admin' && $selectedReturn->review_reason)
                    <div class="p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg mb-4">
                        <p class="font-semibold text-red-800">Alasan Penolakan Admin:</p>
                        <p class="text-red-700">{{ $selectedReturn->review_reason }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <p class="font-semibold text-gray-700 mb-1">Foto Barang:</p>
                    @if($selectedReturn->item_proof)
                        <img src="{{ asset('storage/' . $selectedReturn->item_proof) }}" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                    @else
                        <p class="text-gray-500">Belum ada foto barang</p>
                    @endif
                </div>

                @if($selectedReturn->status === 'reviewed')
                    <div class="mb-4">
                        <p class="font-semibold text-blue-600 mb-2">Silakan upload resi</p>
                        <input type="file" wire:model="shipmentProof.{{ $selectedReturn->id }}" class="border p-2 rounded w-full mb-3">
                        <button wire:click="uploadShipment({{ $selectedReturn->id }})" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold shadow">
                            Upload Resi
                        </button>
                    </div>
                @endif

                @if(in_array($selectedReturn->status, ['shipped','received']))
                    <div class="mb-4">
                        <p class="font-semibold text-gray-700 mb-2">Resi Customer:</p>
                        @if($selectedReturn->shipment_proof)
                            <img src="{{ asset('storage/' . $selectedReturn->shipment_proof) }}" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                        @else
                            <p class="text-gray-500">Belum diupload</p>
                        @endif
                    </div>
                @endif

                @if($selectedReturn->status === 'received')
                    <div class="mb-4">
                        <p class="font-semibold text-gray-700 mb-2">Bukti Refund:</p>
                        @if($selectedReturn->refund_proof)
                            <img src="{{ asset('storage/' . $selectedReturn->refund_proof) }}" class="w-full rounded-lg border object-contain max-h-64 shadow-sm hover:shadow-lg transition">
                        @else
                            <p class="text-gray-500">Belum diupload</p>
                        @endif
                    </div>
                @endif

                <div class="flex justify-end mt-4">
                    <button wire:click="closeDetailModal" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg font-semibold">Tutup</button>
                </div>
            </div>
        </div>
    @endif
</div>
