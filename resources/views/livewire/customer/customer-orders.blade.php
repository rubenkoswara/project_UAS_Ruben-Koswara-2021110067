<div x-data="{ 
    openModal: false,
    showToast: false, 
    toastMsg: '',
    init() {
        @if(session()->has('toast'))
            this.triggerToast('{{ session('toast') }}');
        @endif
    },
    triggerToast(msg) {
        this.toastMsg = msg;
        this.showToast = true;
        setTimeout(() => { this.showToast = false }, 4000);
    }
}" class="py-10 bg-gray-50 min-h-screen">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="text-left">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight uppercase">Daftar Pesanan</h2>
                <p class="text-gray-500 text-sm mt-1 uppercase tracking-widest font-bold text-[10px]">Kelola dan pantau status pesanan Anda</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
                <span class="text-gray-400 pl-3 text-[10px] font-black uppercase tracking-widest">Filter:</span>
                <select wire:model.live="searchStatus" class="border-none focus:ring-0 text-xs font-black text-blue-600 cursor-pointer rounded-lg bg-transparent uppercase">
                    <option value="">Semua Status</option>
                    <option value="pending">⏳ Pending</option>
                    <option value="processing">📦 Processing</option>
                    <option value="dikirim">🚚 Dikirim</option>
                    <option value="completed">✅ Completed</option>
                    <option value="canceled">❌ Canceled</option>
                    <option value="returned">🔄 Returned</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-left">
        @forelse($orders as $order)
            <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-center mb-5">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.15em] mb-0.5">Order ID</span>
                            <p class="text-gray-900 font-black text-lg tracking-tight">#{{ $order->id }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider
                            @if($order->status === 'pending') bg-amber-50 text-amber-600 border border-amber-100
                            @elseif($order->status === 'processing') bg-blue-50 text-blue-600 border border-blue-100
                            @elseif($order->status === 'dikirim') bg-indigo-50 text-indigo-600 border border-indigo-100
                            @elseif($order->status === 'completed') bg-emerald-50 text-emerald-600 border border-emerald-100
                            @elseif($order->status === 'canceled') bg-rose-50 text-rose-600 border border-rose-100
                            @else bg-gray-50 text-gray-600 @endif">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="mb-5 flex items-center gap-4 bg-gray-50/80 p-3.5 rounded-2xl border border-gray-100/50">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-blue-600 border border-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest leading-none mb-1">Pelanggan</p>
                            <p class="text-sm font-black text-gray-900 truncate">{{ $order->user->name ?? 'Guest User' }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6 px-1">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <span class="text-gray-400 font-bold uppercase tracking-widest text-[9px]">Ekspedisi</span>
                            </div>
                            <span class="text-blue-600 font-black uppercase italic text-xs tracking-tight">
                                @if($order->shippingMethod)
                                    {{ $order->shippingMethod->name }}
                                @else
                                    @php $info = is_array($order->shipping_info) ? $order->shipping_info : json_decode($order->shipping_info, true); @endphp
                                    {{ $info['name'] ?? 'JNE' }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                            <span class="text-gray-400 font-bold uppercase tracking-widest text-[9px]">Total Pembayaran</span>
                            <span class="text-gray-900 font-black text-base">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6">
                    <button wire:click="selectOrder({{ $order->id }})"
                        class="w-full bg-gray-900 text-white py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-[0.15em] hover:bg-blue-600 shadow-lg shadow-gray-200 transition-all duration-300 active:scale-[0.97] flex items-center justify-center gap-2">
                        <span>Detail Pesanan</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 bg-white rounded-[3rem] border-2 border-dashed border-gray-100 text-center shadow-inner">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <p class="text-gray-400 font-black uppercase text-xs tracking-[0.25em]">Belum ada pesanan ditemukan</p>
            </div>
        @endforelse
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>

        @if($selectedOrder)
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-md z-[999] flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col my-auto max-h-[90vh] text-left">
                
                <div class="px-8 py-6 bg-gray-50 border-b flex justify-between items-center sticky top-0 z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center text-blue-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 uppercase leading-none">{{ $selectedOrder->user->name ?? 'User' }}</h3>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Order ID: #{{ $selectedOrder->id }}</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="p-2 bg-white rounded-full shadow-sm hover:bg-red-50 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto space-y-8 bg-white">
                    @php 
                        $subtotal = $selectedOrder->orderItems->sum(fn($item) => $item->price * $item->quantity);
                        $shipInfo = is_array($selectedOrder->shipping_info) ? $selectedOrder->shipping_info : json_decode($selectedOrder->shipping_info, true);
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100">
                            <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4">Informasi Pengiriman</h4>
                            
                            <div class="mb-4 flex items-center gap-2">
                                <div class="px-2 py-1 bg-blue-600 rounded-lg">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011 1v2.5a.5.5 0 01-1 0V16zm-7 0h7"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest block leading-none">Jasa Pengiriman:</span>
                                    <p class="text-gray-900 font-black text-base uppercase italic">
                                        @if($selectedOrder->shippingMethod)
                                            {{ $selectedOrder->shippingMethod->name }}
                                        @else
                                            {{ $shipInfo['name'] ?? 'JNE' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.15em] block mb-1">Penerima & Kontak:</span>
                                <p class="text-gray-900 font-extrabold text-base">{{ $shipInfo['no_telp'] ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.15em] block mb-1">Alamat Tujuan:</span>
                                <p class="text-gray-600 text-xs font-bold leading-relaxed italic uppercase tracking-wider">
                                    {{ $shipInfo['alamat'] ?? '' }}, {{ $shipInfo['kelurahan'] ?? '' }}, {{ $shipInfo['kecamatan'] ?? '' }}, {{ $shipInfo['kota'] ?? '' }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100">
                            <h4 class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-3">Metode Pembayaran</h4>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-white rounded-xl shadow-sm border border-indigo-100 text-indigo-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-gray-900 font-black text-lg uppercase tracking-tighter">
                                        {{ $selectedOrder->paymentMethod->name ?? ($selectedOrder->payment_method ?? 'Bank Transfer') }}
                                    </p>
                                    <p class="text-[9px] text-indigo-400 font-bold uppercase tracking-widest mt-1">Status: Terverifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Produk (Fitur Rating & Return Tetap Ada) --}}
                    <div>
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Daftar Produk</h4>
                            
                            @if($selectedOrder->status === 'dikirim')
                                <div class="flex flex-wrap items-center gap-3">
                                    <div class="relative">
                                        <input type="file" wire:model="deliveryProof" id="delivery_upload" class="hidden">
                                        <label for="delivery_upload" class="cursor-pointer bg-white border-2 border-dashed border-gray-200 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase flex items-center gap-2 hover:border-blue-500 transition">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $deliveryProof ? 'Siap Konfirmasi' : 'Upload Bukti Terima' }}
                                        </label>
                                    </div>
                                    <button wire:click="markAsReceived" 
                                        wire:loading.attr="disabled"
                                        class="bg-emerald-600 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 disabled:opacity-50"
                                        @if(!$deliveryProof) disabled @endif>
                                        <span wire:loading.remove>Konfirmasi Diterima</span>
                                        <span wire:loading>Memproses...</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @foreach($selectedOrder->orderItems as $item)
                                <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                                    <div class="flex items-center justify-between p-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-blue-600 text-sm shadow-sm">{{ $item->quantity }}x</div>
                                            <div>
                                                <p class="font-black text-gray-800 text-sm uppercase leading-none mb-1">{{ $item->product->name }}</p>
                                                <p class="text-[10px] text-gray-400 font-bold tracking-widest">@ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <p class="font-black text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>

                                    @if($selectedOrder->status === 'completed')
                                        <div class="p-5 bg-white border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="space-y-3">
                                                <p class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em]">Beri Penilaian</p>
                                                <select wire:model="rating.{{ $item->id }}" class="w-full text-xs rounded-xl border-gray-200 bg-gray-50 font-black focus:ring-amber-500">
                                                    <option value="">Pilih Rating</option>
                                                    <option value="5">⭐⭐⭐⭐⭐ 5 Bintang</option>
                                                    <option value="4">⭐⭐⭐⭐ 4 Bintang</option>
                                                    <option value="3">⭐⭐⭐ 3 Bintang</option>
                                                    <option value="2">⭐⭐ 2 Bintang</option>
                                                    <option value="1">⭐ 1 Bintang</option>
                                                </select>
                                                <textarea wire:model="comment.{{ $item->id }}" placeholder="Tulis ulasan produk..." class="w-full text-xs rounded-xl border-none bg-gray-50 h-16 font-bold"></textarea>
                                                <button wire:click="submitReview({{ $item->id }})" class="w-full py-2 bg-amber-500 text-white rounded-xl text-[10px] font-black uppercase hover:bg-amber-600 transition shadow-lg shadow-amber-100">Kirim Review</button>
                                            </div>
                                            <div class="space-y-3">
                                                <p class="text-[10px] font-black text-rose-500 uppercase tracking-[0.2em]">Ajukan Retur</p>
                                                <textarea wire:model="returnReason.{{ $item->id }}" placeholder="Alasan pengajuan retur..." class="w-full text-xs rounded-xl border-none bg-gray-50 h-16 font-bold"></textarea>
                                                <input type="file" wire:model="returnProof.{{ $item->id }}" class="text-[10px] w-full file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-rose-50 file:text-rose-700">
                                                <button wire:click="submitReturn({{ $item->id }})" class="w-full py-2 bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase hover:bg-rose-700 transition shadow-lg shadow-rose-100">Kirim Komplain</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- PERINCIAN TAGIHAN (FONT BESAR) --}}
                    <div class="p-8 bg-white rounded-[2.5rem] border-2 border-gray-100 shadow-sm">
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 font-black uppercase tracking-[0.15em] text-xs">Subtotal Produk</span>
                                <span class="text-gray-900 font-black text-xl">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-start">
                                <div class="flex flex-col text-left">
                                    <span class="text-gray-400 font-black uppercase tracking-[0.15em] text-xs">Ongkos Kirim</span>
                                    <span class="text-xs text-blue-600 font-black uppercase tracking-widest">
                                        @if($selectedOrder->shippingMethod)
                                            {{ $selectedOrder->shippingMethod->name }}
                                        @else
                                            {{ $shipInfo['name'] ?? 'JNE' }}
                                        @endif
                                        - {{ $shipInfo['service'] ?? '' }}
                                    </span>
                                </div>
                                <span class="text-gray-900 font-black text-xl">Rp {{ number_format($shipInfo['shipping_cost'] ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <div class="py-2"><div class="border-t-2 border-dashed border-gray-100 w-full"></div></div>

                            <div class="flex justify-between items-center">
                                <div class="leading-none text-left">
                                    <span class="text-xs font-black text-blue-600 uppercase tracking-[0.2em]">Total Tagihan</span>
                                    <p class="text-gray-400 text-[10px] font-bold italic mt-1 uppercase tracking-widest">
                                        {{ $selectedOrder->status === 'completed' ? 'Lunas Terbayar' : 'Menunggu Pelunasan' }}
                                    </p>
                                </div>
                                <span class="text-5xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 p-6 flex flex-col items-center text-center">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 leading-none">Bukti Bayar</h4>
                            @if($selectedOrder->payment_proof)
                                <img src="{{ asset('storage/'.$selectedOrder->payment_proof) }}" class="w-full h-32 object-cover rounded-2xl shadow-sm grayscale hover:grayscale-0 transition duration-500">
                            @else
                                <div class="h-32 flex items-center justify-center opacity-20 text-[10px] font-black uppercase tracking-widest leading-none">No Proof</div>
                            @endif
                        </div>
                        <div class="bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 p-6 flex flex-col items-center text-center">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 leading-none">Bukti Resi</h4>
                            @if($selectedOrder->receipt)
                                <img src="{{ asset('storage/'.$selectedOrder->receipt) }}" class="w-full h-32 object-cover rounded-2xl shadow-sm grayscale hover:grayscale-0 transition duration-500">
                            @else
                                <div class="h-32 flex items-center justify-center opacity-20 text-[10px] font-black uppercase tracking-widest leading-none">No Receipt</div>
                            @endif
                        </div>
                        <div class="bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 p-6 flex flex-col items-center text-center">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 leading-none">Bukti Terima</h4>
                            @if($selectedOrder->delivery_proof)
                                <img src="{{ asset('storage/'.$selectedOrder->delivery_proof) }}" class="w-full h-32 object-cover rounded-2xl shadow-sm grayscale hover:grayscale-0 transition duration-500">
                            @else
                                <div class="h-32 flex items-center justify-center opacity-20 text-[10px] font-black uppercase tracking-widest leading-none">Belum Tiba</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-8 py-5 bg-gray-50 border-t flex justify-end sticky bottom-0 z-10">
                    <button wire:click="closeModal" class="px-8 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-100 transition shadow-sm active:scale-95">Tutup Jendela</button>
                </div>
            </div>
        </div>
        @endif

        <div x-show="showToast" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-10 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-200" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[1000] w-full max-w-xs" style="display: none;">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-[1.5rem] shadow-2xl flex items-center gap-3 border border-white/10 text-left">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-black uppercase tracking-widest text-blue-400 leading-none mb-1">Status Sistem</span>
                    <p x-text="toastMsg" class="text-xs font-bold leading-tight"></p>
                </div>
            </div>
        </div>

    </div>
</div>