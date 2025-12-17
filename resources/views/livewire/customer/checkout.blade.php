<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    {{-- Alert --}}
    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT SECTION --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Alamat --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>

                <div class="space-y-4">

                    <div>
                        <label class="font-semibold">Alamat</label>
                        <input type="text" wire:model.live="alamat"
                               class="w-full border rounded px-3 py-2">
                        @error('alamat') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="font-semibold">Kota</label>
                        <input type="text" wire:model.live="kota"
                               class="w-full border rounded px-3 py-2">
                        @error('kota') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="font-semibold">Kecamatan</label>
                        <input type="text" wire:model.live="kecamatan"
                               class="w-full border rounded px-3 py-2">
                        @error('kecamatan') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="font-semibold">Kelurahan</label>
                        <input type="text" wire:model.live="kelurahan"
                               class="w-full border rounded px-3 py-2">
                        @error('kelurahan') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="font-semibold">No Telepon</label>
                        <input type="text" wire:model.live="no_telp"
                               class="w-full border rounded px-3 py-2">
                        @error('no_telp') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>

            {{-- Jasa Pengiriman --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Jasa Pengiriman</h2>

                <label class="font-semibold">Pilih Jasa Pengiriman</label>
                <select wire:model.live="shipping_method"
                        class="w-full border rounded px-3 py-2 mt-2">
                    <option value="">-- Pilih Jasa Kirim --</option>
                    @foreach($shippingMethods as $ship)
                        <option value="{{ $ship->id }}">
                            {{ $ship->name }} - Rp {{ number_format($ship->cost) }}
                        </option>
                    @endforeach
                </select>
                @error('shipping_method') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

                @if($selectedShipping)
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-300 rounded">
                        <p class="font-semibold">Detail Ongkir:</p>
                        <p>Jasa: {{ $selectedShipping->name }}</p>
                        <p>Biaya: Rp {{ number_format($selectedShipping->cost) }}</p>
                    </div>
                @endif
            </div>

            {{-- Metode Pembayaran --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Metode Pembayaran</h2>

                <label class="font-semibold">Pilih Metode Pembayaran</label>
                <select wire:model.live="payment_method"
                        class="w-full border rounded px-3 py-2 mt-2">
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    @foreach($paymentMethods as $pm)
                        <option value="{{ $pm->id }}">
                            {{ $pm->name }} ({{ $pm->bank_name }})
                        </option>
                    @endforeach
                </select>
                @error('payment_method') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

                @if($selectedPayment)
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-300 rounded">
                        <p class="font-semibold">Informasi Rekening:</p>
                        <p>Bank: {{ $selectedPayment->bank_name }}</p>
                        <p>No Rekening: {{ $selectedPayment->account_number }}</p>
                        <p>Atas Nama: {{ $selectedPayment->account_name }}</p>
                    </div>
                @endif

                <div class="mt-4">
                    <label class="font-semibold">Upload Bukti Transfer</label>
                    <input type="file" wire:model="bukti_transfer"
                           class="w-full border rounded px-3 py-2 mt-2">
                    @error('bukti_transfer') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

                    {{-- PREVIEW --}}
                    @if ($bukti_transfer)
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-600 mb-1">Preview:</p>
                            @if(in_array($bukti_transfer->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                <img src="{{ $bukti_transfer->temporaryUrl() }}"
                                     class="max-h-40 rounded shadow">
                            @else
                                <p class="text-gray-500 text-sm">File terupload: {{ $bukti_transfer->getClientOriginalName() }}</p>
                            @endif
                        </div>
                    @endif
                </div>

            </div>

        </div>

        {{-- RIGHT SECTION: Ringkasan --}}
        <div class="bg-white p-6 rounded-lg shadow">

            <h2 class="text-xl font-semibold mb-4">Ringkasan Belanja</h2>

            @foreach($cart as $id => $item)
                <div class="flex justify-between items-center border-b mb-4 pb-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/' . $item['image']) }}"
                             class="w-14 h-14 rounded object-cover">
                        <div>
                            <p class="font-semibold">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                        </div>
                    </div>

                    <div class="font-semibold">
                        Rp {{ number_format($item['price'] * $item['quantity']) }}
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between py-2 text-lg">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($subtotal) }}</span>
            </div>

            <div class="flex justify-between py-2 text-lg">
                <span>Ongkos Kirim:</span>
                <span>Rp {{ number_format($shipping_cost) }}</span>
            </div>

            <div class="border-t my-3"></div>

            <div class="flex justify-between font-bold text-xl">
                <span>Total Bayar:</span>
                <span>Rp {{ number_format($grandTotal) }}</span>
            </div>

            <button wire:click="placeOrder"
                    class="mt-6 w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                Buat Pesanan
            </button>

        </div>

    </div>

</div>
