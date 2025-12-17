<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10">
            <div class="text-left">
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">Keranjang Belanja</h1>
                <p class="text-gray-500 text-sm mt-1">Periksa kembali barang belanjaan Anda sebelum checkout.</p>
            </div>
            <div class="flex items-center gap-2 bg-blue-600 px-5 py-2 rounded-2xl shadow-lg shadow-blue-100">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="text-white text-sm font-black">{{ count($cart) }} Produk</span>
            </div>
        </div>

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                {{-- DAFTAR PRODUK (KIRI) --}}
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden text-left">
                        <ul role="list" class="divide-y divide-gray-100">
                            @foreach($cart as $id => $item)
                                <li class="p-8 flex flex-col sm:flex-row gap-8 hover:bg-gray-50/50 transition duration-300">
                                    <div class="h-32 w-32 flex-shrink-0 overflow-hidden rounded-[1.5rem] border border-gray-100 shadow-inner bg-gray-50">
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                                    </div>

                                    <div class="flex flex-1 flex-col justify-between">
                                        <div class="flex justify-between items-start text-left">
                                            <div>
                                                <h3 class="text-lg font-black text-gray-900 hover:text-blue-600 transition cursor-pointer leading-tight mb-1">{{ $item['name'] }}</h3>
                                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic">Harga Satuan: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                            </div>
                                            <p class="text-lg font-black text-blue-600 tracking-tighter">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                        </div>

                                        <div class="flex flex-1 items-end justify-between mt-6 text-left">
                                            <div class="flex items-center bg-gray-100 rounded-xl p-1 border border-gray-200">
                                                <button wire:click="decrement({{ $id }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white shadow-sm text-gray-600 hover:text-red-500 hover:shadow-md transition focus:outline-none">-</button>
                                                <span class="px-5 font-black text-gray-900 min-w-[45px] text-center text-sm">{{ $item['quantity'] }}</span>
                                                <button wire:click="increment({{ $id }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white shadow-sm text-gray-600 hover:text-blue-600 hover:shadow-md transition focus:outline-none">+</button>
                                            </div>

                                            <button wire:click="remove({{ $id }})" class="flex items-center gap-2 px-4 py-2 text-xs font-black text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition duration-300 group">
                                                <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                HAPUS
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-8 text-left">
                        <a href="{{ route('customer.catalog') }}" class="inline-flex items-center gap-3 text-sm font-black text-gray-400 hover:text-blue-600 transition group">
                            <div class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center group-hover:border-blue-200 group-hover:bg-blue-50 transition">
                                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </div>
                            KEMBALI BELANJA
                        </a>
                    </div>
                </div>

                {{-- RINGKASAN HARGA (KANAN) --}}
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 sticky top-8 text-left">
                        <h2 class="text-xl font-black text-gray-900 mb-8 border-b border-gray-50 pb-4 text-left">Ringkasan Belanja</h2>
                        
                        <div class="space-y-5 mb-8 text-left">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400 font-bold uppercase tracking-widest">Total Barang</span>
                                <span class="font-black text-gray-900">{{ count($cart) }} Item</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400 font-bold uppercase tracking-widest">Subtotal</span>
                                <span class="font-black text-gray-900">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-50">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em]">Total Harga</span>
                                    <span class="text-2xl font-black text-blue-600 tracking-tighter">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        @if(session()->has('cart') && count(session('cart')) > 0)
                            <a href="{{ route('customer.checkout') }}" 
                                class="w-full flex justify-center items-center bg-gray-900 text-white py-4 px-6 rounded-2xl font-black text-lg hover:bg-blue-600 shadow-xl shadow-gray-200 transform transition hover:-translate-y-1 active:scale-95 uppercase tracking-tight">
                                Checkout Sekarang
                            </a>
                        @endif

                        <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-center gap-3 opacity-60">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Transaksi Aman & Terenkripsi</span>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- EMPTY STATE --}}
            <div class="max-w-xl mx-auto bg-white rounded-[3rem] shadow-sm border border-gray-100 p-16 text-center">
                <div class="w-28 h-28 bg-gray-50 text-blue-500 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner border border-gray-100 transform -rotate-6">
                    <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">Keranjang Kosong</h2>
                <p class="text-gray-400 mb-10 text-sm font-medium leading-relaxed px-10">Belum ada barang di sini. Mari jelajahi produk kami dan temukan apa yang Anda butuhkan!</p>
                <a href="{{ route('customer.catalog') }}" class="inline-block bg-gray-900 text-white px-12 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-blue-600 transition shadow-2xl shadow-gray-200 active:scale-95">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>