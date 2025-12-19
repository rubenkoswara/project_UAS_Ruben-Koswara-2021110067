<div class="py-12 bg-gray-50 min-h-screen text-left">
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        @keyframes bounce-subtle { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
        .hover-bounce:hover svg { animation: bounce-subtle 0.6s infinite; }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Pengembalian <span class="text-blue-600">Pesanan</span></h1>
                <p class="text-gray-500 text-sm mt-2 font-medium">Pantau status pengajuan retur dan pengembalian dana Anda secara real-time.</p>
            </div>
            <div class="flex items-center gap-2 bg-white border border-gray-100 px-6 py-3 rounded-2xl shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-black text-lg">
                    {{ $returns->total() }}
                </div>
                <span class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Pengajuan</span>
            </div>
        </div>

        @if(session()->has('toast_success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-5 rounded-r-2xl text-xs font-black uppercase tracking-widest flex items-center gap-3 animate-fade-in shadow-sm">
                <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('toast_success') }}
            </div>
        @endif

        @if($returns->count())
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($returns as $return)
                    <div class="group bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative flex flex-col justify-between">
                        <div>
                            <div class="mb-6 flex justify-between items-start">
                                <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest">#RET-{{ $return->id }}</span>
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm
                                    @if($return->status === 'pending') bg-gray-100 text-gray-500
                                    @elseif($return->status === 'reviewed') bg-blue-100 text-blue-600
                                    @elseif($return->status === 'shipped') bg-orange-100 text-orange-600
                                    @elseif($return->status === 'received') bg-purple-100 text-purple-600
                                    @elseif($return->status === 'completed') bg-emerald-100 text-emerald-600
                                    @elseif(in_array($return->status, ['rejected','rejected_by_admin'])) bg-red-100 text-red-600
                                    @endif">
                                    {{ $return->status }}
                                </span>
                            </div>

                            <div class="space-y-1 mb-8">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Pesanan #{{ $return->order_id }}</p>
                                <h3 class="text-xl font-black text-gray-900 leading-tight group-hover:text-blue-600 transition uppercase tracking-tight">{{ $return->orderItem->product->name }}</h3>
                                <div class="mt-4 p-4 bg-gray-50 rounded-2xl">
                                    <p class="text-gray-500 text-[11px] font-bold italic line-clamp-2">"{{ $return->reason }}"</p>
                                </div>
                            </div>
                        </div>

                        <button wire:click="openDetailModal({{ $return->id }})" 
                                class="w-full py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 shadow-xl shadow-gray-200 transition-all active:scale-95 flex items-center justify-center gap-2">
                            Detail Pengajuan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $returns->links() }}
            </div>
        @else
            <div class="max-w-xl mx-auto bg-white rounded-[3rem] border border-dashed border-gray-300 p-20 text-center">
                <div class="w-24 h-24 bg-gray-50 text-gray-200 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 border border-gray-100">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-2 tracking-tight uppercase">Belum Ada Retur</h2>
                <p class="text-gray-400 text-sm font-medium italic">Riwayat pengembalian barang Anda akan muncul di sini.</p>
            </div>
        @endif

        @if($showDetailModal && $selectedReturn)
            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-md flex items-center justify-center z-[100] p-4">
                <div class="bg-white rounded-[3rem] w-full max-w-4xl flex flex-col max-h-[90vh] shadow-2xl overflow-hidden animate-fade-in border border-gray-100">
                    <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
                        <div>
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em]">Return Dashboard</span>
                            <h2 class="text-2xl font-black text-gray-900 uppercase">Detail Retur <span class="text-gray-400">#RET-{{ $selectedReturn->id }}</span></h2>
                        </div>
                        <button wire:click="closeDetailModal" class="p-4 bg-gray-50 hover:bg-red-50 hover:text-red-500 rounded-2xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="p-8 overflow-y-auto custom-scrollbar flex-1 bg-gray-50/30">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-2 space-y-6">
                                <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                                    <div class="grid grid-cols-2 gap-8">
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Produk Terkait</label>
                                            <p class="text-lg font-black text-gray-900 uppercase leading-tight">{{ $selectedReturn->orderItem->product->name }}</p>
                                            <p class="text-xs font-bold text-blue-600 mt-1">Order ID: #{{ $selectedReturn->order_id }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Status Retur</label>
                                            <span class="inline-block px-4 py-1.5 rounded-xl text-[10px] font-black uppercase bg-gray-900 text-white shadow-lg">
                                                {{ $selectedReturn->status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-8 pt-8 border-t border-gray-100">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-3 tracking-widest">Alasan Pengajuan Anda</label>
                                        <p class="text-sm font-bold text-gray-600 italic leading-relaxed bg-gray-50 p-5 rounded-2xl border border-gray-100">"{{ $selectedReturn->reason }}"</p>
                                    </div>
                                </div>

                                <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                                    <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Lampiran & Bukti Visual
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <p class="text-[10px] font-black text-gray-400 uppercase mb-3">Foto Kondisi Barang</p>
                                            @if($selectedReturn->item_proof)
                                                <img src="{{ asset('storage/' . $selectedReturn->item_proof) }}" class="w-full h-56 object-cover rounded-[2rem] border-4 border-white shadow-md hover:scale-[1.02] transition cursor-pointer" onclick="window.open(this.src)">
                                            @else
                                                <div class="w-full h-56 bg-gray-100 rounded-[2rem] flex items-center justify-center text-gray-300 text-[10px] font-black uppercase border-2 border-dashed">Tidak Ada Foto</div>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="text-[10px] font-black text-gray-400 uppercase mb-3">Bukti Resi Pengiriman Balik</p>
                                            @if($selectedReturn->shipment_proof)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $selectedReturn->shipment_proof) }}" class="w-full h-56 object-cover rounded-[2rem] border-4 border-white shadow-md hover:scale-[1.02] transition cursor-pointer" onclick="window.open(this.src)">
                                                    <div class="absolute top-4 right-4 bg-emerald-500 text-white text-[8px] font-black px-3 py-1 rounded-full uppercase">Terkirim</div>
                                                </div>
                                            @elseif($selectedReturn->status === 'reviewed')
                                                <div class="h-56 flex flex-col items-center justify-center border-2 border-dashed border-blue-200 rounded-[2rem] bg-blue-50/30 p-6 hover:bg-blue-50 transition-all hover-bounce relative overflow-hidden">
                                                    <label class="cursor-pointer w-full h-full flex flex-col items-center justify-center">
                                                        <svg class="w-10 h-10 text-blue-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                        <span class="text-[10px] font-black text-blue-600 uppercase text-center px-4">
                                                            @if(isset($shipmentProof[$selectedReturn->id]))
                                                                <span class="text-emerald-600 italic">File: {{ $shipmentProof[$selectedReturn->id]->getClientOriginalName() }}</span>
                                                            @else
                                                                Klik Untuk Upload Foto Resi
                                                            @endif
                                                        </span>
                                                        <input type="file" wire:model="shipmentProof.{{ $selectedReturn->id }}" class="hidden">
                                                    </label>
                                                </div>
                                                <div wire:loading wire:target="shipmentProof.{{ $selectedReturn->id }}" class="mt-2 text-center">
                                                    <span class="text-[9px] font-black text-blue-500 animate-pulse uppercase">Memproses File...</span>
                                                </div>
                                                @if(isset($shipmentProof[$selectedReturn->id]))
                                                    <button wire:click="uploadShipment({{ $selectedReturn->id }})" wire:loading.attr="disabled" class="w-full mt-4 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95">
                                                        <span wire:loading.remove wire:target="uploadShipment">Kirim Resi Sekarang</span>
                                                        <span wire:loading wire:target="uploadShipment">Mengirim...</span>
                                                    </button>
                                                @endif
                                            @else
                                                <div class="w-full h-56 bg-gray-50 rounded-[2rem] flex flex-col items-center justify-center text-gray-300 text-[10px] font-black uppercase border-2 border-dashed italic p-6 text-center">
                                                    Resi dapat diupload setelah disetujui admin
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                @if($selectedReturn->status === 'rejected_by_admin' && $selectedReturn->review_reason)
                                    <div class="bg-red-600 p-8 rounded-[2.5rem] shadow-xl text-white">
                                        <h3 class="text-[10px] font-black uppercase tracking-widest mb-4 opacity-70 italic">Catatan Penting Admin:</h3>
                                        <p class="text-sm font-bold leading-relaxed italic">"{{ $selectedReturn->review_reason }}"</p>
                                    </div>
                                @endif

                                @if($selectedReturn->status === 'completed' && $selectedReturn->refund_proof)
                                    <div class="bg-emerald-600 p-8 rounded-[2.5rem] shadow-xl text-white">
                                        <h3 class="text-[10px] font-black uppercase tracking-widest mb-4 opacity-70">Refund Selesai</h3>
                                        <p class="text-xs font-bold mb-4">Dana telah berhasil dikembalikan. Lihat bukti di bawah:</p>
                                        <img src="{{ asset('storage/' . $selectedReturn->refund_proof) }}" class="w-full rounded-2xl border-4 border-white/20 shadow-lg cursor-pointer" onclick="window.open(this.src)">
                                    </div>
                                @endif

                                <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">Ringkasan Waktu</h3>
                                    <div class="space-y-4">
                                        <div class="flex justify-between">
                                            <span class="text-[10px] font-black text-gray-400 uppercase">Diajukan</span>
                                            <span class="text-[10px] font-black text-gray-900">{{ $selectedReturn->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-[10px] font-black text-gray-400 uppercase">Update Terakhir</span>
                                            <span class="text-[10px] font-black text-gray-900">{{ $selectedReturn->updated_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 bg-white border-t border-gray-100 flex justify-end">
                        <button wire:click="closeDetailModal" class="px-10 py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95">Tutup Jendela</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>