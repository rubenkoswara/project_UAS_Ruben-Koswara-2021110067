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
            <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Manajemen <span class="text-indigo-600">Pesanan</span></h1>
            <p class="text-gray-600 text-base font-medium mt-2">Panel kontrol transaksi, pengiriman, dan verifikasi bukti pelanggan.</p>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="mb-6 p-5 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-900 rounded-r-2xl flex items-center gap-3 shadow-sm">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-sm font-bold uppercase tracking-widest">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white p-6 rounded-[2.5rem] border border-gray-200 shadow-sm mb-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:flex items-end gap-6">
            <div class="flex-1 text-left">
                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Filter Status</label>
                <select wire:model.live="searchStatus" class="w-full bg-gray-50 border border-gray-100 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 appearance-none transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Diproses</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="canceled">Dibatalkan</option>
                </select>
            </div>
            <div class="flex-1 text-left">
                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Filter Tanggal</label>
                <input type="date" wire:model.live="searchDate" class="w-full bg-gray-50 border border-gray-100 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all">
            </div>
            <button wire:click="$set('searchStatus', ''), $set('searchDate', '')" class="h-[58px] px-8 bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-600 rounded-2xl transition-all font-black text-xs uppercase tracking-widest">
                Reset Filter
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-md overflow-hidden">
        <div class="overflow-x-auto p-6">
            <table class="w-full text-left border-separate border-spacing-y-4">
                <thead>
                    <tr class="text-gray-500 text-xs font-black uppercase tracking-widest">
                        <th class="px-6 py-2">ID & Customer</th>
                        <th class="px-6 py-2">Total Transaksi</th>
                        <th class="px-6 py-2 text-center">Status</th>
                        <th class="px-6 py-2 text-center">Waktu</th>
                        <th class="px-6 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($orders as $order)
                        <tr class="group transition-all duration-200">
                            <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50 rounded-l-[1.5rem]">
                                <span class="text-indigo-600 font-black text-xs block mb-1">#ORD-{{ $order->id }}</span>
                                <span class="text-gray-900 font-extrabold text-base uppercase tracking-tight">{{ $order->user->name }}</span>
                            </td>
                            <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50">
                                <span class="text-gray-900 font-black text-base">Rp {{ number_format($order->total,0,',','.') }}</span>
                            </td>
                            <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
                                        'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                                        'dikirim' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                        'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                        'canceled' => 'bg-rose-100 text-rose-800 border-rose-300',
                                    ];
                                @endphp
                                <span class="px-4 py-2 border rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50 text-center">
                                <div class="text-gray-900 font-bold text-sm">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-gray-500 text-[10px] font-black uppercase">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50 rounded-r-[1.5rem] text-center">
                                <button wire:click="selectOrder({{ $order->id }})" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg transition-all active:scale-95 font-black text-[10px] uppercase tracking-widest">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-24 bg-gray-50 rounded-[2rem] text-gray-400 font-black uppercase text-sm italic">
                                Belum ada pesanan masuk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-gray-100 bg-gray-50/50">{{ $orders->links() }}</div>
    </div>

    @if($showDetailModal && $selectedOrder)
    @php $shippingInfo = json_decode($selectedOrder->shipping_info, true) ?? []; @endphp
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md flex justify-center items-center z-[100] p-4 text-left">
        <div class="bg-white w-full max-w-7xl rounded-[3rem] shadow-2xl flex flex-col max-h-[95vh] overflow-hidden animate-modal border border-gray-100">
            
            <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase">Informasi <span class="text-indigo-600">Lengkap</span></h2>
                    <p class="text-xs font-black text-gray-400 mt-1 uppercase tracking-widest">Transaction ID: #ORD-{{ $selectedOrder->id }} | {{ $selectedOrder->created_at->format('d M Y H:i') }}</p>
                </div>
                <button wire:click="closeDetailModal" class="p-4 bg-gray-50 hover:bg-red-50 hover:text-red-600 rounded-2xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-8 overflow-y-auto custom-scrollbar bg-gray-50/30 flex-1">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    
                    <div class="lg:col-span-3 space-y-6">
                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Alamat Pengiriman Lengkap
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Penerima</label>
                                        <p class="text-xl font-black text-gray-900 uppercase tracking-tight">{{ $shippingInfo['nama_penerima'] ?? $selectedOrder->user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nomor Telepon / WhatsApp</label>
                                        <p class="text-lg font-black text-indigo-600">{{ $shippingInfo['no_telp'] ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kurir & Layanan</label>
                                        <div class="flex items-center gap-3">
                                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-[10px] font-black uppercase border border-indigo-100 italic">{{ $shippingInfo['shipping'] ?? '-' }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 italic">{{ $shippingInfo['service'] ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Alamat Lengkap</label>
                                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                            <p class="text-sm font-bold text-gray-800 leading-relaxed uppercase">{{ $shippingInfo['alamat'] ?? '-' }}</p>
                                            <div class="mt-4 grid grid-cols-3 gap-4 border-t border-gray-200 pt-4">
                                                <div>
                                                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">Kelurahan</label>
                                                    <p class="text-xs font-black text-gray-900 uppercase">{{ $shippingInfo['kelurahan'] ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">Kecamatan</label>
                                                    <p class="text-xs font-black text-gray-900 uppercase">{{ $shippingInfo['kecamatan'] ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">Kota/Kab</label>
                                                    <p class="text-xs font-black text-gray-900 uppercase">{{ $shippingInfo['kota'] ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6">Galeri Bukti & Lampiran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-3">1. Bukti Pembayaran</label>
                                    @if($selectedOrder->payment_proof)
                                        <img src="{{ asset('storage/' . $selectedOrder->payment_proof) }}" class="w-full h-48 object-cover rounded-[2rem] border-4 border-white shadow-md cursor-pointer hover:scale-[1.02] transition" onclick="window.open(this.src)">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-[2rem] flex items-center justify-center border-2 border-dashed text-gray-300 font-black text-[10px] uppercase">Belum Upload</div>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-3">2. Foto Resi (Receipt)</label>
                                    @if($selectedOrder->receipt)
                                        <img src="{{ asset('storage/' . $selectedOrder->receipt) }}" class="w-full h-48 object-cover rounded-[2rem] border-4 border-white shadow-md cursor-pointer hover:scale-[1.02] transition" onclick="window.open(this.src)">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-[2rem] flex items-center justify-center border-2 border-dashed text-gray-300 font-black text-[10px] uppercase">Belum Ada</div>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase block mb-3">3. Bukti Pengiriman</label>
                                    @if($selectedOrder->delivery_proof)
                                        <img src="{{ asset('storage/' . $selectedOrder->delivery_proof) }}" class="w-full h-48 object-cover rounded-[2rem] border-4 border-white shadow-md cursor-pointer hover:scale-[1.02] transition" onclick="window.open(this.src)">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 rounded-[2rem] flex items-center justify-center border-2 border-dashed text-gray-300 font-black text-[10px] uppercase">Belum Ada</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6">Daftar Produk</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="border-b border-gray-100">
                                            <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Item Produk</th>
                                            <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Jumlah (Qty)</th>
                                            <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($selectedOrder->orderItems as $item)
                                        <tr>
                                            <td class="py-5">
                                                <p class="text-gray-900 font-extrabold text-sm uppercase tracking-tight">{{ $item->product->name }}</p>
                                                <p class="text-[10px] text-gray-400 font-bold">Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="py-5 text-center">
                                                <span class="inline-flex items-center justify-center bg-indigo-50 text-indigo-700 font-black text-xs w-10 h-10 rounded-xl border border-indigo-100">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>
                                            <td class="py-5 text-right">
                                                <p class="text-gray-900 font-black text-base">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-indigo-700 p-8 rounded-[2.5rem] shadow-xl text-white relative overflow-hidden">
                            <h3 class="text-xs font-black opacity-60 uppercase tracking-widest mb-4">Total Bayar</h3>
                            <p class="text-3xl font-black tracking-tighter">Rp {{ number_format($selectedOrder->total, 0, ',', '.') }}</p>
                            <div class="mt-4 pt-4 border-t border-white/10 space-y-2">
                                <p class="text-[10px] font-black uppercase tracking-widest">Metode Pembayaran</p>
                                <p class="text-xs font-bold opacity-90 uppercase">{{ $selectedOrder->payment_method ?? 'TRANSFER MANUAL' }}</p>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm space-y-6">
                            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span> Kendali Status
                            </h3>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase block mb-2">Update Status</label>
                                <select wire:model="newStatus" class="w-full bg-gray-50 border-0 rounded-xl p-4 text-sm font-black text-gray-800 uppercase focus:ring-2 focus:ring-indigo-500 transition-all">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Diproses</option>
                                    <option value="dikirim">Dikirim</option>
                                    <option value="completed">Selesai</option>
                                    <option value="canceled">Dibatalkan</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase block mb-2">Upload Resi</label>
                                <input type="file" wire:model="resi" class="w-full text-[10px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-black">
                            </div>
                            <button wire:click="updateStatus" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 transition-all active:scale-95">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
</div>