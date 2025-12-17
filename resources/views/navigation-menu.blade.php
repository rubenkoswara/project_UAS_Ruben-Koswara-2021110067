<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-[100] border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('customer.catalog') }}" class="flex items-center group">
                        <div class="bg-blue-600 p-2 rounded-2xl shadow-lg shadow-blue-200 group-hover:scale-110 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2c-5.523 0-10 4.477-10 10s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-3-9c.552 0 1 .448 1 1s-.448 1-1 1-1-.448-1-1 .448-1 1-1zm6 0c.552 0 1 .448 1 1s-.448 1-1 1-1-.448-1-1 .448-1 1-1zm-3 4c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4z"/>
                            </svg>
                        </div>
                        <span class="ms-3 font-black text-xl text-gray-900 tracking-tighter uppercase">Renesca <span class="text-blue-600">Aquatic</span></span>
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    @php
                        $navLinks = Auth::user()->role === 'admin' 
                            ? [
                                'admin.dashboard' => 'Dashboard',
                                'admin.products' => 'Produk',
                                'admin.orders' => 'Pesanan',
                                'admin.order-returns' => 'Retur',
                                'admin.reports' => 'Laporan',
                            ]
                            : [
                                'customer.catalog' => 'Katalog',
                                'customer.cart' => 'Keranjang',
                                'customer.orders' => 'Pesanan Saya',
                                'customer.returns' => 'Retur Saya',
                            ];
                    @endphp

                    @foreach($navLinks as $route => $label)
                        <a href="{{ route($route) }}" 
                           class="inline-flex items-center px-4 py-2 text-[11px] font-black uppercase tracking-widest transition duration-300 rounded-xl
                           {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-600' : 'text-gray-400 hover:text-gray-900 hover:bg-gray-50' }}">
                            {{ $label }}
                        </a>
                    @endforeach

                    @if(Auth::user()->role === 'admin')
                        <div class="relative" x-data="{ openAdmin: false }">
                            <button @click="openAdmin = !openAdmin" class="inline-flex items-center px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition">
                                Master Data
                                <svg class="ms-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="openAdmin" @click.away="openAdmin = false" class="absolute left-0 mt-2 w-48 bg-white border border-gray-100 rounded-[1.5rem] shadow-xl p-2 z-[110]">
                                <a href="{{ route('admin.categories') }}" class="block px-4 py-2 text-[10px] font-black text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-xl uppercase">Kategori</a>
                                <a href="{{ route('admin.brands') }}" class="block px-4 py-2 text-[10px] font-black text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-xl uppercase">Merek</a>
                                <a href="{{ route('admin.shipping-methods') }}" class="block px-4 py-2 text-[10px] font-black text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-xl uppercase">Shipping</a>
                                <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-[10px] font-black text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-xl uppercase">Pengguna</a>
                                <a href="{{ route('admin.payment-methods') }}" class="block px-4 py-2 text-[10px] font-black text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-xl uppercase">Pembayaran</a>
                                <div class="border-t border-gray-50 my-1"></div>
                                <a href="{{ route('admin.trash') }}" class="block px-4 py-2 text-[10px] font-black text-red-400 hover:bg-red-50 rounded-xl uppercase">Trash Bin</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 p-1 pr-3 bg-gray-50 rounded-2xl hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                                <img class="h-9 w-9 rounded-xl object-cover border-2 border-white shadow-sm" src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                                <div class="text-left hidden lg:block">
                                    <p class="text-[10px] font-black text-gray-900 leading-none uppercase">{{ Auth::user()->name }}</p>
                                    <p class="text-[9px] font-bold text-blue-500 uppercase tracking-tighter">{{ Auth::user()->role }}</p>
                                </div>
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="p-2">
                                <x-dropdown-link href="{{ route('profile.show') }}" class="rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500">
                                    {{ __('My Profile') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-50 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="rounded-xl text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-50">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-2xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-50">
        <div class="pt-4 pb-6 space-y-2 px-4">
            @foreach($navLinks as $route => $label)
                <a href="{{ route($route) }}" class="block px-4 py-3 rounded-2xl text-xs font-black uppercase tracking-widest {{ request()->routeIs($route) ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-gray-500 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</nav>