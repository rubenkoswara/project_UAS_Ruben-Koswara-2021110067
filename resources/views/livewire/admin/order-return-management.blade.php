<div class="p-8 bg-gray-50 min-h-screen text-left">
    <style>
        @keyframes modalEntry {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal { animation: modalEntry 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Manajemen <span class="text-indigo-600">Retur</span></h1>
            <p class="text-gray-600 text-base font-medium mt-2">Kelola pengajuan pengembalian barang dan dana dari pelanggan.</p>
        </div>
    </div>

    @if($toastMessage)
        <div class="mb-6 p-5 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-900 rounded-r-2xl flex items-center gap-3 shadow-sm animate-pulse">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-sm font-black uppercase tracking-widest">{{ $toastMessage }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($returns as $return)
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <span class="text-indigo-600 font-black text-xs uppercase tracking-widest">#RET-{{ $return->id }}</span>
                        @php
                            $statusMap = [
                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                'reviewed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'received' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                'rejected_by_admin' => 'bg-rose-100 text-rose-800 border-rose-200',
                            ];
                        @endphp
                        <span class="px-4 py-1.5 border rounded-full text-[10px] font-black uppercase tracking-tighter {{ $statusMap[$return->status] ?? 'bg-gray-100' }}">
                            {{ $return->status }}
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-1 truncate">{{ $return->order->user->name }}</h3>
                    <p class="text-sm font-bold text-gray-400 uppercase mb-4">{{ $return->orderItem->product->name }} (x{{ $return->orderItem->quantity }})</p>
                    
                    <div class="bg-gray-50 p-4 rounded-2xl mb-6">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Alasan Retur</p>
                        <p class="text-xs font-bold text-gray-700 leading-relaxed italic line-clamp-2">"{{ $return->reason }}"</p>
                    </div>
                </div>

                <button wire:click="selectReturn({{ $return->id }})" class="w-full py-4 bg-gray-900 group-hover:bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95 shadow-lg">
                    Detail Pengajuan
                </button>
            </div>
        @empty
            <div class="col-span-full py-24 bg-white rounded-[3rem] border border-dashed border-gray-300 text-center">
                <p class="text-gray-400 font-black uppercase tracking-widest italic">Belum ada pengajuan retur</p>
            </div>
        @endforelse
    </div>

    @if($selectedReturn)
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md flex justify-center items-center z-[110] p-4 text-left">
        <div class="bg-white w-full max-w-5xl rounded-[3rem] shadow-2xl flex flex-col max-h-[95vh] overflow-hidden animate-modal border border-gray-100">
            
            <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase">Detail <span class="text-indigo-600">Retur</span></h2>
                    <p class="text-xs font-black text-gray-400 mt-1 uppercase tracking-widest">Return ID: #RET-{{ $selectedReturn->id }} | Transaksi: #ORD-{{ $selectedReturn->order->id }}</p>
                </div>
                <button wire:click="closeModal" class="p-4 bg-gray-50 hover:bg-red-50 hover:text-red-600 rounded-2xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-8 overflow-y-auto custom-scrollbar bg-gray-50/30 flex-1">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Data Pelanggan & Produk
                            </h3>
                            <div class="grid grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Customer</label>
                                        <p class="text-base font-black text-gray-900 uppercase">{{ $selectedReturn->order->user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Email / WA</label>
                                        <p class="text-sm font-bold text-gray-700">{{ $selectedReturn->order->user->email }}</p>
                                        <p class="text-sm font-bold text-indigo-600">{{ $selectedReturn->order->user->phone ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Produk</label>
                                        <p class="text-base font-black text-gray-900 uppercase">{{ $selectedReturn->orderItem->product->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Kuantitas & Total</label>
                                        <p class="text-sm font-bold text-gray-700">{{ $selectedReturn->orderItem->quantity }} Pcs</p>
                                        <p class="text-lg font-black text-gray-900">Rp {{ number_format($selectedReturn->order->total,0,',','.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6">Bukti Visual (Lampiran)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-3 italic">Bukti Barang (Customer)</label>
                                    @if($selectedReturn->item_proof)
                                        <img src="{{ asset('storage/'.$selectedReturn->item_proof) }}" class="w-full h-48 object-cover rounded-[2rem] border-4 border-white shadow-md hover:scale-[1.02] transition cursor-pointer" onclick="window.open(this.src)">
                                    @else
                                        <div class="h-48 bg-gray-100 rounded-[2rem] border-2 border-dashed flex items-center justify-center text-gray-300 font-black text-[10px] uppercase">Tidak ada bukti</div>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-3 italic">Bukti Resi (Pengiriman Balik)</label>
                                    @if($selectedReturn->shipment_proof)
                                        <img src="{{ asset('storage/'.$selectedReturn->shipment_proof) }}" class="w-full h-48 object-cover rounded-[2rem] border-4 border-white shadow-md hover:scale-[1.02] transition cursor-pointer" onclick="window.open(this.src)">
                                    @else
                                        <div class="h-48 bg-gray-100 rounded-[2rem] border-2 border-dashed flex items-center justify-center text-gray-300 font-black text-[10px] uppercase">Belum dikirim</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gray-900 p-8 rounded-[2.5rem] shadow-xl text-white">
                            <h3 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-4 italic">Alasan Pengajuan</h3>
                            <p class="text-sm font-bold leading-relaxed italic text-gray-300">"{{ $selectedReturn->reason }}"</p>
                            @if($selectedReturn->status === 'rejected_by_admin' && $selectedReturn->review_reason)
                                <div class="mt-6 pt-6 border-t border-white/10">
                                    <p class="text-[10px] font-black text-rose-400 uppercase mb-2">Alasan Penolakan Admin</p>
                                    <p class="text-xs font-bold text-rose-200 italic">{{ $selectedReturn->review_reason }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-6">Aksi Manajemen</h3>
                            
                            @if($selectedReturn->status === 'pending')
                                <div class="space-y-4">
                                    <button wire:click="approveReturn" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition shadow-lg shadow-emerald-100">Setujui Retur</button>
                                    <div class="pt-4 border-t border-gray-100">
                                        <input type="text" wire:model="rejectReason" placeholder="ALASAN PENOLAKAN..." class="w-full bg-gray-50 border-0 rounded-xl p-4 text-[10px] font-bold text-gray-800 uppercase mb-3">
                                        <button wire:click="rejectReturn" class="w-full py-4 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition">Tolak Pengajuan</button>
                                    </div>
                                </div>
                            @elseif($selectedReturn->status === 'shipped')
                                <div class="space-y-4">
                                    <button wire:click="confirmReceived" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 transition">Barang Sudah Diterima</button>
                                    <input type="text" wire:model="rejectReason" placeholder="ALASAN TOLAK BARANG..." class="w-full bg-gray-50 border-0 rounded-xl p-4 text-[10px] font-bold text-gray-800 uppercase mb-3">
                                    <button wire:click="rejectReturn" class="w-full py-4 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition">Tolak Paket</button>
                                </div>
                            @elseif($selectedReturn->status === 'received')
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-gray-400 uppercase block italic">Langkah Akhir: Upload Bukti Refund</label>
                                    <input type="file" wire:model="refundProof" class="w-full text-[10px] text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-amber-50 file:text-amber-700 file:font-black">
                                    <button wire:click="uploadRefundProof" class="w-full py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-amber-100 transition">Selesaikan Refund</button>
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <span class="text-xs font-black text-gray-300 uppercase italic tracking-widest">Tidak ada aksi tersedia</span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="p-8 bg-gray-50 text-right">
                <button wire:click="closeModal" class="px-8 py-4 bg-white border border-gray-200 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-100 transition">Tutup Detail</button>
            </div>
        </div>
    </div>
    @endif
</div>