<nav class="sticky top-4 z-[100] mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm rounded-[2rem] px-6 py-3">
        <div class="flex justify-between items-center h-12">
            
            <div class="flex shrink-0 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        @if (config('app.logo_url'))
                            {{-- Jika ada URL logo di .env, tampilkan sebagai gambar bulat --}}
                            <img src="{{ config('app.logo_url') }}" class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" alt="Logo">
                        @else
                            {{-- Fallback ke komponen x-logo jika URL tidak ada --}}
                            <x-logo class="h-10 w-10 rounded-full" />
                        @endif
                    </div>

                    <div class="flex flex-col">
                        <span class="text-lg font-black text-slate-900 tracking-tighter leading-none">
                            RENESCA
                        </span>
                        <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] leading-none mt-1">
                            AQUATIC
                        </span>
                    </div>
                </a>
            </div>

            <div class="flex items-center space-x-1">
                <a href="{{ route('login') }}" 
                   class="px-5 py-2.5 text-[11px] font-black uppercase tracking-[0.15em] text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-xl transition-all">
                    {{ __('Log in') }}
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2.5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-[0.15em] rounded-xl hover:bg-indigo-600 shadow-lg shadow-slate-200 transition-all active:scale-95">
                        {{ __('Register') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>