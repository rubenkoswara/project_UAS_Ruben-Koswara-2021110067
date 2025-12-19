<div class="p-8 bg-slate-50 min-h-screen text-left font-sans">
    <style>
        @keyframes modalEntry {
            from { opacity: 0; transform: scale(0.98) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal { animation: modalEntry 0.3s cubic-bezier(0.2, 1, 0.3, 1) forwards; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
    </style>

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
            <span class="text-indigo-600 font-bold text-sm tracking-[0.2em] uppercase mb-2 block">Administrator Panel</span>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-500">Retur</span></h1>
            <p class="text-slate-500 text-lg font-medium mt-3">Monitoring dan proses pengembalian pesanan secara efisien.</p>
        </div>
    </div>

    @if($toastMessage)
        <div class="mb-8 p-4 bg-emerald-500 text-white rounded-3xl flex items-center gap-4 shadow-lg shadow-emerald-200/50 animate-bounce">
            <div class="bg-white/20 p-2 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-sm font-bold uppercase tracking-wider">{{ $toastMessage }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($returns as $return)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-10px_rgba(79,70,229,0.15)] transition-all duration-500 group overflow-hidden flex flex-col justify-between border-b-4 border-b-transparent hover:border-b-indigo-500">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <div class="bg-indigo-50 px-4 py-1 rounded-full">
                            <span class="text-indigo-600 font-black text-[10px] uppercase tracking-widest">#{{ $return->id }}</span>
                        </div>
                        @php
                            $statusMap = [
                                'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'reviewed' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'shipped' => 'bg-purple-50 text-purple-600 border-purple-100',
                                'received' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'rejected_by_admin' => 'bg-rose-50 text-rose-600 border-rose-100',
                            ];
                        @endphp
                        <span class="px-3 py-1 border rounded-xl text-[10px] font-black uppercase tracking-wider {{ $statusMap[$return->status] ?? 'bg-slate-50 text-slate-500' }}">
                            ● {{ str_replace('_', ' ', $return->status) }}
                        </span>
                    </div>

                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-1 truncate">{{ $return->order->user->name }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wide mb-6">{{ $return->orderItem->product->name }} <span class="text-indigo-500 ml-1">×{{ $return->orderItem->quantity }}</span></p>
                    
                    <div class="bg-white p-5 rounded-[2rem] relative overflow-hidden border border-slate-100 shadow-sm group-hover:border-indigo-100 transition-colors">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Alasan Pelanggan</p>
                        <p class="text-xs font-bold text-slate-600 leading-relaxed italic line-clamp-2">"{{ $return->reason }}"</p>
                    </div>
                </div>

                <div class="px-8 pb-8 mt-4">
                    <button wire:click="selectReturn({{ $return->id }})" class="w-full py-4 bg-slate-900 hover:bg-indigo-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all active:scale-95 shadow-xl shadow-slate-200 flex items-center justify-center gap-2 group-hover:shadow-indigo-200">
                        Periksa Detail
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 bg-white rounded-[3rem] border-4 border-dashed border-slate-100 text-center">
                <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4"></path></svg>
                </div>
                <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-sm">Antrian retur kosong</p>
            </div>
        @endforelse
    </div>

    @if($selectedReturn)
        <div x-data="{ zoomedImageUrl: null }" class="fixed inset-0 bg-slate-900/90 backdrop-blur-xl flex justify-center items-center z-[110] p-4 text-left">
            <div class="bg-white w-full max-w-6xl rounded-[3.5rem] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden animate-modal">
                
                <div class="p-10 border-b border-slate-50 flex justify-between items-center sticky top-0 bg-white z-10">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter leading-none">Detail <span class="text-indigo-600">Verifikasi</span></h2>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">ID: #RET-{{ $selectedReturn->id }}</span>
                                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded-lg border border-indigo-100">Order: #ORD-{{ $selectedReturn->order->id }}</span>
                            </div>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="p-5 bg-slate-50 hover:bg-rose-50 hover:text-rose-500 rounded-[2rem] transition-all group">
                        <svg class="w-6 h-6 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
    
                <div class="p-10 overflow-y-auto custom-scrollbar flex-1 bg-slate-50/50">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        
                        <div class="lg:col-span-8 space-y-8">
                            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm">
                                <h3 class="text-xs font-black text-indigo-500 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                    Informasi Utama
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                    <div class="space-y-6">
                                        <div class="p-4 bg-slate-50 rounded-3xl border border-slate-100">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Customer</label>
                                            <p class="text-lg font-black text-slate-900 uppercase">{{ $selectedReturn->order->user->name }}</p>
                                            <p class="text-xs font-bold text-slate-500 mt-1">{{ $selectedReturn->order->user->email }}</p>
                                            <p class="text-xs font-black text-indigo-600 mt-2">{{ $selectedReturn->order->user->phone ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-6">
                                        <div class="p-4 bg-slate-50 rounded-3xl border border-slate-100">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Item Produk</label>
                                            <p class="text-lg font-black text-slate-900 uppercase truncate">{{ $selectedReturn->orderItem->product->name }}</p>
                                            <div class="flex justify-between items-center mt-3">
                                                <span class="text-xs font-bold text-slate-500">{{ $selectedReturn->orderItem->quantity }} Unit</span>
                                                <span class="text-lg font-black text-indigo-600">Rp {{ number_format($selectedReturn->order->total,0,',','.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm">
                                <h3 class="text-xs font-black text-indigo-500 uppercase tracking-[0.2em] mb-8">Bukti Visual & Dokumen</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    @php 
                                        $proofs = [
                                            ['label' => 'Bukti Barang', 'field' => 'item_proof', 'color' => 'slate'],
                                            ['label' => 'Bukti Resi', 'field' => 'shipment_proof', 'color' => 'slate'],
                                            ['label' => 'Bukti Refund', 'field' => 'refund_proof', 'color' => 'emerald']
                                        ];
                                    @endphp
    
                                    @foreach($proofs as $p)
                                    <div>
                                        <label class="text-[9px] font-black text-slate-400 uppercase block mb-4 tracking-widest">{{ $p['label'] }}</label>
                                        @if($selectedReturn->{$p['field']})
                                            <div class="relative group cursor-pointer" @click="zoomedImageUrl = '{{ asset('storage/'.$selectedReturn->{$p['field']}) }}'">
                                                <img src="{{ asset('storage/'.$selectedReturn->{$p['field']}) }}" class="w-full h-56 object-cover rounded-[2rem] border-4 border-white shadow-md group-hover:shadow-xl transition-all group-hover:scale-[1.03]">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem] flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                                </div>
                                            </div>
                                        @else
                                            <div class="h-56 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-300 gap-2">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="text-[9px] font-black uppercase tracking-widest">Kosong</span>
                                            </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
    
                        <div class="lg:col-span-4 space-y-8">
                            <div class="bg-white p-8 rounded-[3rem] shadow-lg shadow-slate-200 border border-slate-100 text-slate-900 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                                <h3 class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-6 italic">Kronologi / Alasan</h3>
                                
                                <div class="bg-slate-50 border border-slate-100 p-6 rounded-[2rem] shadow-inner mb-6">
                                    <p class="text-sm font-bold leading-relaxed italic text-slate-700">"{{ $selectedReturn->reason }}"</p>
                                </div>
                                
                                @if($selectedReturn->status === 'rejected_by_admin' && $selectedReturn->review_reason)
                                    <div class="mt-6 pt-6 border-t border-slate-100">
                                        <p class="text-[9px] font-black text-rose-500 uppercase mb-2 tracking-widest">Feedback Penolakan:</p>
                                        <p class="text-xs font-bold text-rose-800 italic leading-relaxed bg-rose-50 border border-rose-100 p-4 rounded-2xl">{{ $selectedReturn->review_reason }}</p>
                                    </div>
                                @endif
                            </div>
    
                            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
                                <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                    <span class="w-1.5 h-4 bg-indigo-600 rounded-full"></span>
                                    Control Panel
                                </h3>
                                
                                @if($selectedReturn->status === 'pending')
                                    <div class="space-y-4">
                                        <button wire:click="approveReturn" class="w-full py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all shadow-lg shadow-emerald-100 active:scale-[0.98]">Setujui Retur</button>
                                        <div class="pt-6 border-t border-slate-50 space-y-4">
                                            <textarea wire:model="rejectReason" placeholder="TULIS ALASAN PENOLAKAN..." class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-[11px] font-bold text-slate-800 uppercase focus:ring-rose-500 focus:border-rose-500 min-h-[100px]"></textarea>
                                            <button wire:click="rejectReturn" class="w-full py-4 bg-rose-500 hover:bg-rose-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest transition shadow-lg shadow-rose-100 active:scale-[0.98]">Tolak Pengajuan</button>
                                        </div>
                                    </div>
                                @elseif($selectedReturn->status === 'shipped')
                                    <div class="space-y-4">
                                        <button wire:click="confirmReceived" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-indigo-100 transition active:scale-[0.98]">Konfirmasi Diterima</button>
                                        <div class="pt-4 space-y-4">
                                            <input type="text" wire:model="rejectReason" placeholder="ALASAN TOLAK PAKET..." class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-[11px] font-bold text-slate-800 uppercase focus:ring-rose-500 focus:border-rose-500">
                                            <button wire:click="rejectReturn" class="w-full py-4 bg-rose-500 hover:bg-rose-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest transition shadow-lg shadow-rose-100 active:scale-[0.98]">Tolak Paket</button>
                                        </div>
                                    </div>
                                @elseif($selectedReturn->status === 'received')
                                    <div class="space-y-5">
                                        <div class="p-6 bg-amber-50 rounded-3xl border border-amber-100">
                                            <label class="text-[10px] font-black text-amber-700 uppercase block mb-4 italic tracking-widest text-center">Final Step: Upload Refund</label>
                                            <input type="file" wire:model="refundProof" class="w-full text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-white file:text-amber-700 file:font-black file:shadow-sm file:text-[9px]">
                                        </div>
                                        <button wire:click="uploadRefundProof" class="w-full py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-amber-100 transition active:scale-[0.98]">Selesaikan Refund</button>
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                                        <p class="text-[10px] font-black text-slate-400 uppercase italic tracking-widest px-4 leading-relaxed">Status terkunci: Tidak ada aksi yang diperlukan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-8 bg-slate-50/80 border-t border-slate-100 text-right backdrop-blur-md">
                    <button wire:click="closeModal" class="px-12 py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-900 hover:text-white transition-all active:scale-95 shadow-sm">Tutup Jendela</button>
                </div>
            </div>
    
            <div x-show="zoomedImageUrl" style="display: none;" @keydown.escape.window="zoomedImageUrl = null" class="fixed inset-0 bg-black/90 backdrop-blur-lg flex items-center justify-center z-[120]">
                <img :src="zoomedImageUrl" class="max-w-[90vw] max-h-[90vh] rounded-3xl shadow-2xl">
                <button @click="zoomedImageUrl = null" class="absolute top-8 right-8 text-white/50 hover:text-white transition text-6xl font-light">&times;</button>
            </div>
        </div>
    @endif</div>