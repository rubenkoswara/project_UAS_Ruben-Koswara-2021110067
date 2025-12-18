<div x-data="{ openModal: false }" class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-left">
            <a href="{{ route('customer.catalog') }}" class="inline-flex items-center gap-2 text-xs font-black text-gray-400 hover:text-blue-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                KEMBALI KE KATALOG
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <div class="relative group cursor-zoom-in" @click="openModal = true">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-200 to-indigo-200 rounded-[3rem] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                <div class="relative bg-white p-3 rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-[550px] object-cover rounded-[2.5rem] transform transition duration-700 group-hover:scale-105">
                    
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <span class="bg-white/90 backdrop-blur px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl">Klik untuk Perbesar</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col text-left space-y-8">
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-4 py-1.5 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-blue-100">
                            {{ $product->category->name ?? 'Kategori Umum' }}
                        </span>
                        
                        @if($product->stock > 0)
                            <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                Stok Tersedia: {{ $product->stock }}
                            </span>
                        @else
                            <span class="px-4 py-1.5 bg-red-100 text-red-700 border border-red-200 rounded-xl text-[10px] font-black uppercase tracking-widest">
                                Stok Habis
                            </span>
                        @endif

                        <span class="px-4 py-1.5 bg-gray-100 text-gray-500 rounded-xl text-[10px] font-black uppercase tracking-widest">
                            Brand: {{ $product->brand->name ?? '-' }}
                        </span>
                    </div>

                    <h1 class="text-5xl font-black text-gray-900 tracking-tight leading-tight uppercase">{{ $product->name }}</h1>
                    
                    <div class="p-6 bg-white rounded-[2rem] border-2 border-gray-50 shadow-sm inline-block">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Harga Penawaran</span>
                        <p class="text-4xl font-black text-blue-600 tracking-tighter">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="text-left">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4 pl-1">Ringkasan Produk</h3>
                    <div class="text-gray-600 text-sm leading-relaxed font-medium bg-white/50 p-6 rounded-[2rem] border border-gray-100 italic">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                @auth
                <div class="flex flex-col gap-4 pt-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center bg-white rounded-2xl p-1.5 border border-gray-200 shadow-sm">
                            <button wire:click="decrement" class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:text-red-500 hover:bg-red-50 transition font-black text-xl">-</button>
                            <input type="number" readonly wire:model="quantity" 
                                   class="border-none focus:ring-0 w-16 text-center font-black text-lg text-gray-900 bg-transparent">
                            <button wire:click="increment" class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition font-black text-xl">+</button>
                        </div>

                        <button wire:click="addToCart"
                                class="flex-1 bg-gray-900 text-white px-8 py-5 rounded-[1.5rem] font-black text-sm uppercase tracking-widest hover:bg-blue-600 shadow-2xl shadow-gray-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Tambahkan ke Keranjang
                        </button>
                    </div>
                </div>
                @endauth
            </div>
        </div>

        <div class="mt-24 border-t border-gray-100 pt-16">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div class="text-left">
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Ulasan Pelanggan</h2>
                    <p class="text-gray-400 text-sm font-medium mt-1 uppercase tracking-widest">Apa kata mereka tentang produk ini</p>
                </div>
                
                <div class="flex items-center gap-4 bg-white px-6 py-3 rounded-2xl border border-gray-100 shadow-sm self-start">
                    <span class="text-3xl font-black text-blue-600">{{ number_format($product->reviews->avg('rating') ?: 0, 1) }}</span>
                    <div class="flex flex-col">
                        <div class="flex text-amber-400">
                            @php $avg = $product->reviews->avg('rating') ?: 0; @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $avg ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $product->reviews->count() }} Review Terverifikasi</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($product->reviews as $review)
                    <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition duration-300">
                        <div class="text-left">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-black text-xs border border-blue-100">
                                        {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-900 uppercase leading-none">{{ $review->user->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-100 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm font-medium leading-relaxed italic">
                                "{{ $review->comment }}"
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-gray-300 mb-4 shadow-sm border border-gray-100">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em]">Belum ada ulasan untuk produk ini</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="openModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/90 backdrop-blur-sm"
             style="display: none;"
             @keydown.escape.window="openModal = false">
            
            <div @click.away="openModal = false" class="relative max-w-4xl w-full">
                <button @click="openModal = false" class="absolute -top-12 right-0 text-white hover:text-blue-400 flex items-center gap-2 font-black uppercase text-xs tracking-widest transition">
                    TUTUP [ESC] <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-auto rounded-[2rem] shadow-2xl border-4 border-white/10">
            </div>
        </div>

    </div>
</div>