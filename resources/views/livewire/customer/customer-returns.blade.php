<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 text-left">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">Pengembalian Pesanan</h1>
                <p class="text-gray-500 text-sm mt-2">Pantau status pengajuan retur dan pengembalian dana Anda.</p>
            </div>
            <div class="flex items-center gap-2 bg-white border border-gray-100 px-4 py-2 rounded-2xl shadow-sm">
                <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 font-black text-sm">
                    {{ $returns->total() }}
                </div>
                <span class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Pengajuan</span>
            </div>
        </div>

        {{-- Toast Messages --}}
        @if(session()->has('toast_success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 p-4 rounded-2xl text-xs font-black uppercase tracking-widest flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('toast_success') }}
            </div>
        @endif

        @if($returns->count())
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($returns as $return)
                    <div class="group bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden text-left">
                        <div class="mb-6">
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm
                                @if($return->status === 'pending') bg-gray-100 text-gray-500
                                @elseif($return->status === 'reviewed') bg-blue-100 text-blue-600
                                @elseif($return->status === 'shipped') bg-orange-100 text-orange-600
                                @elseif($return->status === 'received') bg-emerald-100 text-emerald-600
                                @elseif(in_array($return->status, ['rejected','rejected_by_admin'])) bg-red-100 text-red-600
                                @endif">
                                {{ ucfirst($return->status) }}
                            </span>
                        </div>

                        <div class="space-y-1 mb-6">
                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em]">ID Pesanan #{{ $return->order->id }}</p>
                            <h3 class="text-xl font-black text-gray-900 leading-tight group-hover:text-blue-600 transition">{{ $return->orderItem->product->name }}</h3>
                            <p class="text-gray-400 text-sm italic line-clamp-2 mt-2">"{{ $return->reason }}"</p>
                        </div>

                        <button wire:click="openDetailModal({{ $return->id }})" 
                                class="w-full py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 shadow-lg shadow-gray-200 transition-all active:scale-95 flex items-center justify-center gap-2">
                            Lihat Detail Retur
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $returns->links() }}
            </div>
        @else
            <div class="max-w-xl mx-auto bg-white rounded-[3rem] border border-gray-100 p-16 text-center shadow-sm">
                <div class="w-24 h-24 bg-gray-50 text-gray-300 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-gray-100 shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Tidak Ada Retur</h2>
                <p class="text-gray-400 text-sm font-medium leading-relaxed italic">Riwayat pengembalian barang Anda akan muncul di sini.</p>
            </div>
        @endif

        {{-- MODAL DETAIL (ELEGANT VERSION) --}}
        @if($showDetailModal && $selectedReturn)
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-[100] p-4 animate-fade-in">
                <div class="bg-white rounded-[3rem] w-full max-w-2xl p-10 overflow-y-auto max-h-[90vh] shadow-2xl relative text-left">
                    <button wire:click="closeDetailModal" class="absolute top-8 right-8 text-gray-300 hover:text-red-500 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    
                    <div class="mb-8">
                        <span class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em]">Detail Informasi</span>
                        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Retur Pesanan #{{ $selectedReturn->order->id }}</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="p-6 bg-gray-50 rounded-[2rem] border border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status Saat Ini</p>
                            <span class="px-4 py-1 rounded-xl text-xs font-black uppercase tracking-widest inline-block
                                @if($selectedReturn->status === 'pending') bg-gray-200 text-gray-600
                                @elseif($selectedReturn->status === 'reviewed') bg-blue-500 text-white
                                @elseif($selectedReturn->status === 'shipped') bg-orange-500 text-white
                                @elseif($selectedReturn->status === 'received') bg-emerald-500 text-white
                                @elseif(in_array($selectedReturn->status, ['rejected','rejected_by_admin'])) bg-red-500 text-white
                                @endif">
                                {{ $selectedReturn->status }}
                            </span>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[2rem] border border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Produk</p>
                            <p class="text-sm font-black text-gray-900">{{ $selectedReturn->orderItem->product->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span> Alasan Pengajuan
                            </h4>
                            <p class="text-gray-500 text-sm italic bg-gray-50 p-6 rounded-[1.5rem] border border-gray-100">"{{ $selectedReturn->reason }}"</p>
                        </div>

                        @if($selectedReturn->status === 'rejected_by_admin' && $selectedReturn->review_reason)
                            <div class="p-6 bg-red-50 rounded-[1.5rem] border border-red-100">
                                <p class="font-black text-red-600 text-xs uppercase tracking-widest mb-2">Catatan Penolakan Admin:</p>
                                <p class="text-red-700 text-sm font-medium">{{ $selectedReturn->review_reason }}</p>
                            </div>
                        @endif

                        <div>
                            <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span> Bukti Barang & Dokumen
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Foto Barang</p>
                                    @if($selectedReturn->item_proof)
                                        <img src="{{ asset('storage/' . $selectedReturn->item_proof) }}" class="w-full h-48 object-cover rounded-[1.5rem] border-2 border-gray-50 shadow-sm">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-[1.5rem] flex items-center justify-center text-gray-400 text-[10px] font-black uppercase">No Image</div>
                                    @endif
                                </div>

                                @if($selectedReturn->shipment_proof || $selectedReturn->status === 'reviewed')
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Resi Pengiriman</p>
                                    @if($selectedReturn->shipment_proof)
                                        <img src="{{ asset('storage/' . $selectedReturn->shipment_proof) }}" class="w-full h-48 object-cover rounded-[1.5rem] border-2 border-gray-50 shadow-sm">
                                    @elseif($selectedReturn->status === 'reviewed')
                                        <div class="h-48 flex flex-col items-center justify-center border-2 border-dashed border-blue-200 rounded-[1.5rem] bg-blue-50/30 p-4">
                                            <input type="file" wire:model="shipmentProof.{{ $selectedReturn->id }}" class="text-[10px] mb-3 w-full">
                                            <button wire:click="uploadShipment({{ $selectedReturn->id }})" class="w-full py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase shadow-md shadow-blue-100">Upload Resi</button>
                                        </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($selectedReturn->status === 'received' && $selectedReturn->refund_proof)
                            <div>
                                <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4 flex items-center gap-2 text-emerald-600">
                                    <span class="w-1.5 h-1.5 bg-emerald-600 rounded-full"></span> Bukti Refund Selesai
                                </h4>
                                <img src="{{ asset('storage/' . $selectedReturn->refund_proof) }}" class="w-full h-auto rounded-[1.5rem] border-4 border-emerald-50">
                            </div>
                        @endif
                    </div>

                    <div class="mt-10 flex justify-end">
                        <button wire:click="closeDetailModal" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">Tutup Jendela</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>