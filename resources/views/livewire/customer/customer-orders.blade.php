<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Pesanan</h2>
                <p class="text-gray-500 text-sm mt-1">Kelola dan pantau status pesanan pelanggan Anda.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
                <span class="text-gray-500 pl-3 text-sm font-semibold uppercase tracking-wider">Filter Status:</span>
                <select wire:model.live="searchStatus" class="border-none focus:ring-0 text-sm font-bold text-blue-600 cursor-pointer rounded-lg bg-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending">⏳ Pending</option>
                    <option value="processing">📦 Processing</option>
                    <option value="completed">✅ Completed</option>
                    <option value="canceled">❌ Canceled</option>
                    <option value="returned">🔄 Returned</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
            @forelse($orders as $order)
                <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div class="bg-gray-50 px-3 py-1 rounded-lg border border-gray-100">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Order ID</span>
                                <p class="text-gray-900 font-black">#{{ $order->id }}</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase
                                @if($order->status === 'pending') bg-amber-100 text-amber-700
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                @elseif($order->status === 'completed') bg-emerald-100 text-emerald-700
                                @elseif($order->status === 'canceled') bg-rose-100 text-rose-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="mb-4 flex items-center gap-3 bg-gray-50/50 p-3 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Pelanggan</p>
                                <p class="text-sm font-black text-gray-900">{{ $order->user->name ?? 'Guest' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2 mb-6 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 font-medium">Total</span>
                                <span class="text-gray-900 font-bold">Rp {{ number_format($order->total,0,',','.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-400">Tanggal</span>
                                <span class="text-gray-600 font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <button wire:click="selectOrder({{ $order->id }})"
                            class="w-full bg-gray-900 text-white py-3 rounded-2xl font-bold text-sm hover:bg-blue-600 shadow-lg shadow-gray-200 transition-all active:scale-95">
                            Detail Pesanan
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 bg-white rounded-3xl border border-dashed border-gray-300 text-center">
                    <p class="text-gray-500 font-medium tracking-tight italic">Belum ada pesanan ditemukan.</p>
                </div>
            @endforelse
        </div>

        @if($selectedOrder)
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-md z-50 flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                
                <div class="px-8 py-6 bg-gray-50 border-b flex justify-between items-center text-left">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center text-blue-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-2xl font-black text-gray-900">{{ $selectedOrder->user->name ?? 'User' }}</h3>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Order ID: #{{ $selectedOrder->id }}</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="p-2 bg-white rounded-full shadow-sm hover:bg-red-50 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto space-y-8 text-left">
                    @php $ship = json_decode($selectedOrder->shipping_info, true); @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 text-left">
                            <h4 class="text-xs font-black text-blue-600 uppercase tracking-widest mb-4">Informasi Pengiriman</h4>
                            
                            <div class="flex items-start gap-3 mb-4 text-left">
                                <div class="mt-1 bg-blue-100 p-1.5 rounded-lg text-blue-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div class="text-left">
                                    <span class="text-[10px] font-bold text-blue-400 uppercase leading-none block mb-1">Nomor Telepon / WA:</span>
                                    <p class="text-gray-900 font-extrabold text-base">{{ $ship['no_telp'] ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 text-left">
                                <div class="mt-1 bg-blue-100 p-1.5 rounded-lg text-blue-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="text-left">
                                    <span class="text-[10px] font-bold text-blue-400 uppercase leading-none block mb-1">Alamat Lengkap:</span>
                                    <p class="text-gray-600 text-sm leading-relaxed italic">
                                        {{ $ship['alamat'] }}, {{ $ship['kelurahan'] }}, {{ $ship['kecamatan'] }}, {{ $ship['kota'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-blue-100 flex justify-between items-center">
                                <span class="text-xs text-blue-400 uppercase font-bold tracking-tighter">Kurir Layanan</span>
                                <p class="text-blue-700 font-black text-sm uppercase">{{ $ship['shipping'] }}</p>
                            </div>
                        </div>

                        <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100 text-left">
                            <h4 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-3 text-left">Metode Pembayaran</h4>
                            <div class="flex items-center gap-3 text-left">
                                <div class="p-3 bg-white rounded-xl shadow-sm border border-indigo-100">
                                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <p class="text-gray-900 font-extrabold text-lg uppercase">
                                    {{ $selectedOrder->paymentMethod?->name ?? $selectedOrder->payment_method ?? 'Bank Transfer' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-left">
                        <h4 class="text-sm font-black text-gray-900 mb-4 uppercase tracking-[0.2em] text-left">Daftar Produk</h4>
                        <div class="space-y-3">
                            @foreach($selectedOrder->orderItems as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100 text-left">
                                    <div class="flex items-center gap-4 text-left">
                                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-blue-600 text-sm shadow-sm">
                                            {{ $item->quantity }}x
                                        </div>
                                        <div class="text-left">
                                            <p class="font-bold text-gray-800 text-sm">{{ $item->product->name }}</p>
                                            <p class="text-[10px] text-gray-400 italic font-medium">@ Rp {{ number_format($item->price,0,',','.') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-black text-gray-900">Rp {{ number_format($item->price * $item->quantity,0,',','.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-6 bg-white rounded-[2rem] border-2 border-gray-100 shadow-sm text-left">
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-500 text-sm font-medium text-left">
                                <span>Subtotal Produk</span>
                                <span class="text-gray-900">Rp {{ number_format(collect($selectedOrder->orderItems)->sum(fn($i) => $i->price * $i->quantity),0,',','.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500 text-sm font-medium text-left">
                                <span>Ongkos Kirim</span>
                                <span class="text-gray-900">Rp {{ number_format($ship['shipping_cost'] ?? 0,0,',','.') }}</span>
                            </div>
                            <div class="border-t border-dashed border-gray-200 my-2 text-left"></div>
                            <div class="flex justify-between items-center pt-2 text-left">
                                <div class="text-left">
                                    <span class="text-xs font-black text-blue-600 uppercase tracking-widest">Total Tagihan</span>
                                    <p class="text-gray-400 text-[10px] italic">Lunas / Belum Lunas</p>
                                </div>
                                <span class="text-3xl font-black text-gray-900 tracking-tighter">
                                    Rp {{ number_format($selectedOrder->total,0,',','.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <div class="bg-gray-50 rounded-[2rem] border border-dashed border-gray-300 p-6 flex flex-col items-center group transition-all hover:border-blue-400 text-left">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 text-center">Bukti Pembayaran</h4>
                            @if($selectedOrder->payment_proof)
                                <div class="relative overflow-hidden rounded-2xl shadow-md bg-white w-full">
                                    <img src="{{ asset('storage/'.$selectedOrder->payment_proof) }}" class="w-full h-40 object-cover group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <a href="{{ asset('storage/'.$selectedOrder->payment_proof) }}" target="_blank" class="bg-white text-gray-900 px-4 py-2 rounded-full text-[10px] font-black uppercase">Zoom Gambar</a>
                                    </div>
                                </div>
                            @else
                                <div class="h-40 flex flex-col items-center justify-center opacity-30">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-[10px] font-bold uppercase">No Image</p>
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-50 rounded-[2rem] border border-dashed border-gray-300 p-6 flex flex-col items-center group transition-all hover:border-emerald-400 text-left">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 text-center">Bukti Pengiriman</h4>
                            @if($selectedOrder->receipt)
                                <div class="relative overflow-hidden rounded-2xl shadow-md bg-white w-full">
                                    <img src="{{ asset('storage/'.$selectedOrder->receipt) }}" class="w-full h-40 object-cover group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <a href="{{ asset('storage/'.$selectedOrder->receipt) }}" target="_blank" class="bg-white text-gray-900 px-4 py-2 rounded-full text-[10px] font-black uppercase">Lihat Full</a>
                                    </div>
                                </div>
                            @else
                                <div class="h-40 flex flex-col items-center justify-center opacity-30">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a2 2 0 002 2h10a2 2 0 002-2v-4a1 1 0 00-1-1h-2"></path></svg>
                                    <p class="text-[10px] font-bold uppercase">No Resi</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-8 py-5 bg-gray-50 border-t flex justify-end gap-3 text-left">
                    <button wire:click="closeModal" class="px-8 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-100 transition shadow-sm">Tutup Halaman</button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>