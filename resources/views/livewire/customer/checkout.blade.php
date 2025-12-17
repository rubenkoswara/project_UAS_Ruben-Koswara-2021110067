<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Checkout</h1>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <span class="text-blue-600 font-semibold">Keranjang</span>
                <span>/</span>
                <span class="font-semibold text-gray-900">Pembayaran</span>
                <span>/</span>
                <span>Selesai</span>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session()->has('error'))
            <div class="flex items-center p-4 mb-6 text-red-800 border-l-4 border-red-500 bg-red-50 rounded-r-lg shadow-sm">
                <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="flex items-center p-4 mb-6 text-green-800 border-l-4 border-green-500 bg-green-50 rounded-r-lg shadow-sm">
                <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <div class="text-sm font-medium">{{ session('message') }}</div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- LEFT SECTION: Form --}}
            <div class="lg:col-span-7 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <h2 class="text-lg font-bold text-gray-800">Alamat Pengiriman</h2>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea wire:model.live="alamat" rows="2" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                                @error('alamat') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kota</label>
                                <input type="text" wire:model.live="kota" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('kota') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan</label>
                                <input type="text" wire:model.live="kecamatan" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('kecamatan') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kelurahan</label>
                                <input type="text" wire:model.live="kelurahan" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('kelurahan') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon / WhatsApp</label>
                                <input type="text" wire:model.live="no_telp" placeholder="08xxxx" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('no_telp') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v1a2 2 0 01-2 2H4a2 2 0 01-2-2v-1a2 2 0 012-2m16 0h-3.82l-1.44-1.44a1 1 0 00-1.42 0L12.18 13H4"></path></svg>
                            Pengiriman
                        </h2>
                        <select wire:model.live="shipping_method" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Pilih Kurir</option>
                            @foreach($shippingMethods as $ship)
                                <option value="{{ $ship->id }}">{{ $ship->name }} (+Rp {{ number_format($ship->cost) }})</option>
                            @endforeach
                        </select>
                        @error('shipping_method') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror

                        @if($selectedShipping)
                            <div class="mt-4 p-3 bg-blue-50 rounded-xl text-sm border border-blue-100">
                                <p class="text-blue-800 font-medium">{{ $selectedShipping->name }}</p>
                                <p class="text-blue-600">Estimasi sampai sesuai layanan kurir.</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Pembayaran
                        </h2>
                        <select wire:model.live="payment_method" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Pilih Bank</option>
                            @foreach($paymentMethods as $pm)
                                <option value="{{ $pm->id }}">{{ $pm->name }} ({{ $pm->bank_name }})</option>
                            @endforeach
                        </select>
                        @error('payment_method') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror

                        @if($selectedPayment)
                            <div class="mt-4 p-3 bg-indigo-50 rounded-xl text-xs border border-indigo-100">
                                <p class="font-bold text-indigo-900 mb-1">Transfer ke:</p>
                                <p class="text-indigo-800">{{ $selectedPayment->bank_name }} - {{ $selectedPayment->account_number }}</p>
                                <p class="text-indigo-800 font-medium">a/n {{ $selectedPayment->account_name }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Bukti Transfer</h2>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                            </div>
                            <input type="file" wire:model="bukti_transfer" class="hidden" />
                        </label>
                    </div>
                    @error('bukti_transfer') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror

                    @if ($bukti_transfer)
                        <div class="mt-4 flex items-center gap-4 p-2 bg-gray-50 rounded-xl border border-gray-200">
                            @if(in_array($bukti_transfer->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                <img src="{{ $bukti_transfer->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg shadow-sm">
                            @endif
                            <div class="text-sm">
                                <p class="font-medium text-gray-700">File siap dikirim</p>
                                <p class="text-gray-500">{{ $bukti_transfer->getClientOriginalName() }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT SECTION: Order Summary --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>

                    <div class="max-h-96 overflow-y-auto pr-2 space-y-4 mb-6">
                        @foreach($cart as $id => $item)
                            <div class="flex gap-4">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 rounded-xl object-cover border border-gray-100">
                                    <span class="absolute -top-2 -right-2 bg-gray-800 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">{{ $item['quantity'] }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-800 line-clamp-1">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-gray-500">Unit: Rp {{ number_format($item['price']) }}</p>
                                </div>
                                <div class="text-sm font-bold text-gray-900">
                                    Rp {{ number_format($item['price'] * $item['quantity']) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 border-t border-gray-100 pt-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Pengiriman</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($shipping_cost) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-extrabold text-gray-900 pt-2 border-t border-dashed">
                            <span>Total Bayar</span>
                            <span class="text-blue-600 text-2xl">Rp {{ number_format($grandTotal) }}</span>
                        </div>
                    </div>

                    <button wire:click="placeOrder"
                            wire:loading.attr="disabled"
                            class="mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-blue-200 shadow-lg transform transition active:scale-95 flex items-center justify-center gap-2 group">
                        <span wire:loading.remove>Konfirmasi Pesanan</span>
                        <span wire:loading>Memproses...</span>
                        <svg wire:loading.remove class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <p class="text-center text-xs text-gray-400 mt-4 italic">
                        *Dengan mengklik tombol, Anda menyetujui syarat & ketentuan kami.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>