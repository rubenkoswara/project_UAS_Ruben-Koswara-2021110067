<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

    @if(count($cart) > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4">Product</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Quantity</th>
                        <th class="p-4">Subtotal</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        <tr class="border-b">
                            <td class="p-4 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                                <span>{{ $item['name'] }}</span>
                            </td>
                            <td class="p-4">Rp {{ number_format($item['price']) }}</td>
                            <td class="p-4 flex items-center gap-2">
                                <button wire:click="decrement({{ $id }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                <span>{{ $item['quantity'] }}</span>
                                <button wire:click="increment({{ $id }})" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                            </td>
                            <td class="p-4 font-semibold">Rp {{ number_format($item['price'] * $item['quantity']) }}</td>
                            <td class="p-4">
                                <button wire:click="remove({{ $id }})" class="text-red-600 hover:underline">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4 flex justify-end items-center gap-6 font-bold text-lg">
                <span>Total:</span>
                <span>Rp {{ number_format($this->total) }}</span>
            </div>

            <div class="mt-6 flex justify-end">
            @if(session()->has('cart') && count(session('cart')) > 0)
                <a href="{{ route('customer.checkout') }}"
                    class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition">
                    Proceed to Checkout
                </a>
            @endif
            </div>
        </div>
    @else
        <p class="text-gray-500">Your cart is empty.</p>
    @endif
</div>
