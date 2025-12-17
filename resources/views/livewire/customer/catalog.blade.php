<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div class="text-left">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Katalog Produk</h1>
                <p class="text-gray-500 text-sm mt-1">Temukan produk terbaik untuk kebutuhan Anda.</p>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Cari produk..."
                        class="pl-10 pr-4 py-2.5 w-full bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition">
                </div>

                <div class="relative w-full md:w-56">
                    <select wire:model.live="selectedCategory"
                        class="appearance-none w-full bg-white border border-gray-200 rounded-2xl px-4 py-2.5 text-gray-600 font-medium focus:ring-2 focus:ring-blue-500 shadow-sm cursor-pointer transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col h-full">
                    
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-md px-3 py-1 rounded-xl text-[10px] font-black text-blue-600 uppercase tracking-widest shadow-sm">
                                {{ $product->category->name ?? 'Produk' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow text-left">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-lg font-black text-gray-900 leading-tight group-hover:text-blue-600 transition">
                                {{ $product->name }}
                            </h2>
                        </div>

                        <div class="flex items-center gap-2 mb-4">
                            @php
                                $rating = round($product->reviews->avg('rating'), 1);
                                $fullStars = floor($rating);
                            @endphp
                            <div class="flex text-yellow-400">
                                <span class="text-sm font-bold">⭐ {{ $rating > 0 ? $rating : '0' }}</span>
                            </div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">({{ $product->reviews->count() }} Review)</span>
                        </div>

                        <div class="mt-auto">
                            <div class="flex flex-col mb-4">
                                <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Harga</span>
                                <p class="text-xl font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>

                            <a href="{{ route('customer.product-detail', $product->id) }}" 
                               class="block w-full text-center bg-gray-900 text-white py-3 rounded-2xl font-bold text-sm hover:bg-blue-600 shadow-lg shadow-gray-200 transition-all active:scale-95">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 bg-white rounded-[3rem] border border-dashed border-gray-300 flex flex-col items-center justify-center">
                    <div class="bg-gray-50 p-6 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-2.586 2.586a2 2 0 01-2.828 0L12 14l-2.586 2.586a2 2 0 01-2.828 0L4 13"></path></svg>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest">Produk tidak ditemukan</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 flex justify-center">
            <div class="p-2 bg-white rounded-2xl shadow-sm border border-gray-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>