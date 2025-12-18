<x-guest-layout>
    <div class="min-h-screen bg-[#f8fafc] flex flex-col justify-center items-center p-6">
        <div class="w-full max-w-[450px] bg-white rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-200 overflow-hidden relative">
            
            <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>

            <div class="p-10 lg:p-12">
                <div class="flex flex-col items-center mb-10">
                    <div class="mb-6 transform hover:scale-110 transition-transform duration-500">
                        <x-authentication-card-logo />
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1 text-center">Silakan masuk ke akun Anda untuk mengelola laporan.</p>
                </div>

                <x-validation-errors class="mb-6 p-4 bg-rose-50 rounded-2xl border border-rose-100 text-xs font-bold text-rose-600" />

                @session('status')
                    <div class="mb-6 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-xs font-bold text-emerald-600">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <x-label for="email" value="{{ __('Email') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2" />
                        <x-input id="email" class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-900" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-2">
                            <x-label for="password" value="{{ __('Password') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400" />
                            @if (Route::has('password.request'))
                                <a class="text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition" href="{{ route('password.request') }}">
                                    {{ __('Lupa?') }}
                                </a>
                            @endif
                        </div>
                        <x-input id="password" class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-900" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    </div>

                    <div class="p-4 bg-slate-50 rounded-[2rem] border border-slate-100 flex flex-col items-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <span class="text-[10px] font-black uppercase text-rose-600 mt-3 tracking-widest">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center px-2">
                        <label for="remember_me" class="flex items-center group cursor-pointer">
                            <x-checkbox id="remember_me" name="remember" class="rounded-md border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5" />
                            <span class="ms-3 text-sm font-bold text-slate-500 group-hover:text-slate-900 transition">{{ __('Ingat saya') }}</span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <x-button class="w-full justify-center py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-indigo-600 active:scale-95 transition-all shadow-xl shadow-slate-200">
                            {{ __('Masuk Sekarang') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>

        <p class="mt-8 text-xs font-bold text-slate-400 uppercase tracking-widest">
            &copy; {{ date('Y') }} • Report Dashboard System
        </p>
    </div>
</x-guest-layout>