<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Product Catalog</h1>

    {{-- Search & Filter --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <input type="text" wire:model.debounce.300ms="search"
            placeholder="Search products..."
            class="border rounded-lg px-4 py-2 w-full md:w-1/2 focus:ring focus:ring-blue-300 focus:border-blue-500">

        <select wire:model="selectedCategory"
            class="border rounded-lg px-4 py-2 w-full md:w-1/4 focus:ring focus:ring-blue-300 focus:border-blue-500">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col">
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover rounded-md mb-4">
                <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-500 text-sm">{{ $product->category->name ?? '-' }}</p>
                <p class="text-blue-600 font-bold mt-2">Rp {{ number_format($product->price) }}</p>
                <div class="mt-2 flex items-center">
                    @php
                        $rating = round($product->reviews->avg('rating'),1);
                    @endphp
                    <span class="text-yellow-400 mr-2">⭐ {{ $rating ?? 0 }}</span>
                    <span class="text-gray-500 text-sm">({{ $product->reviews->count() }})</span>
                </div>
                {{-- Button View Details --}}
                <a href="{{ route('customer.product-detail', $product->id) }}" 
                   class="mt-auto bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700 transition mt-4">
                   View Details
                </a>
            </div>
        @empty
            <p class="col-span-full text-gray-500 text-center">No products found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
