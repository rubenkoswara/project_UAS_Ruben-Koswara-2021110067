<x-guest-layout>
    <div class="min-h-screen bg-[#f8fafc] flex flex-col justify-center items-center p-6">
        <div class="w-full max-w-[550px] bg-white rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-200 overflow-hidden relative">
            
            <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>

            <div class="p-10 lg:p-12">
                <div class="flex flex-col items-center mb-8">
                    <div class="mb-6 transform hover:scale-110 transition-transform duration-500">
                        <x-authentication-card-logo />
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight text-center">Buat Akun Baru</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1 text-center">Daftar untuk mulai mengelola laporan penjualan Anda.</p>
                </div>

                <x-validation-errors class="mb-6 p-4 bg-rose-50 rounded-2xl border border-rose-100 text-xs font-bold text-rose-600" />

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-label for="name" value="{{ __('Nama Lengkap') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2" />
                            <x-input id="name" class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-900" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Anda" />
                        </div>

                        <div class="space-y-2">
                            <x-label for="email" value="{{ __('Email') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2" />
                            <x-input id="email" class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-900" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-label for="password" value="{{ __('Password') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2" />
                            <x-input id="password" class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-900" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                        </div>

                        <div class="space-y-2">
                            <x-label for="password_confirmation" value="{{ __('Konfirmasi') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2" />
                            <x-input id="password_confirmation" class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-900" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-[2rem] border border-slate-100 flex flex-col items-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <span class="text-[10px] font-black uppercase text-rose-600 mt-3 tracking-widest">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="px-2">
                            <label for="terms" class="flex items-center group cursor-pointer">
                                <x-checkbox name="terms" id="terms" required class="rounded-md border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5" />
                                <div class="ms-3 text-xs font-bold text-slate-500 group-hover:text-slate-900 transition">
                                    {!! __('Saya setuju dengan :terms_of_service dan :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-indigo-600 hover:underline">'.__('Ketentuan Layanan').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-indigo-600 hover:underline">'.__('Kebijakan Privasi').'</a>',
                                    ]) !!}
                                </div>
                            </label>
                        </div>
                    @endif

                    <div class="flex flex-col space-y-4 pt-4">
                        <x-button class="w-full justify-center py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-indigo-600 active:scale-95 transition-all shadow-xl shadow-slate-200">
                            {{ __('Daftar Sekarang') }}
                        </x-button>
                        
                        <div class="text-center">
                            <a class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition" href="{{ route('login') }}">
                                {{ __('Sudah punya akun? Masuk di sini') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <p class="mt-8 text-xs font-bold text-slate-400 uppercase tracking-widest">
            &copy; {{ date('Y') }} • Report Dashboard System
        </p>
    </div>
</x-guest-layout>