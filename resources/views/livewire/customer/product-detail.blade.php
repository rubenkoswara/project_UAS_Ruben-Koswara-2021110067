<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Gambar --}}
        <div>
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-[400px] object-cover rounded-lg shadow">
        </div>

        {{-- Detail Produk --}}
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-gray-500 mb-2">
                {{ $product->category->name ?? '-' }} | {{ $product->brand->name ?? '-' }}
            </p>

            {{-- Harga --}}
            <p class="text-2xl font-semibold text-blue-600 mb-4">
                Rp {{ number_format($product->price) }}
            </p>

            {{-- Stok --}}
            <p class="text-gray-700 mb-4">
                Stok: <span class="font-medium">{{ $product->stock }}</span>
            </p>

            {{-- Deskripsi --}}
            <div class="text-gray-700 mb-6">
                {!! nl2br(e($product->description)) !!}
            </div>

            {{-- Quantity + Add to Cart --}}
            @auth
            <div class="flex items-center gap-4 mb-6">
                <button wire:click="decrement" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                <input type="number" min="1" max="{{ $product->stock }}" wire:model="quantity" class="border rounded px-3 py-2 w-24 text-center">
                <button wire:click="increment" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>

                <button wire:click="addToCart"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add to Cart
                </button>
            </div>
            @endauth

            {{-- Flash Message --}}
            @if(session()->has('message'))
                <div class="text-green-600 font-medium">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Reviews --}}
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-4">Customer Reviews</h2>

        @forelse($product->reviews as $review)
            <div class="border-b py-4">
                <div class="flex items-center mb-1">
                    <span class="text-yellow-400 mr-2">⭐ {{ $review->rating }}</span>
                    <span class="font-semibold">{{ $review->user->name ?? 'Anonymous' }}</span>
                </div>
                <p class="text-gray-700">{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-gray-500">No reviews yet.</p>
        @endforelse
    </div>
</div>
