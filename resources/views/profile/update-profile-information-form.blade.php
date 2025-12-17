<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        <span class="text-2xl font-black text-gray-900 uppercase tracking-tight">Informasi <span class="text-indigo-600">Profil</span></span>
    </x-slot>

    <x-slot name="description">
        <span class="text-gray-500 font-medium tracking-wide">{{ __('Update your account\'s profile information and email address.') }}</span>
    </x-slot>

    <x-slot name="form">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 flex flex-col items-start gap-6 bg-gray-50 p-8 rounded-[2.5rem] border border-dashed border-gray-300 mb-4 text-left">
                <input type="file" id="photo" class="hidden"
                       wire:model="photo"
                       x-ref="photo"
                       x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);
                       " />

                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="mt-2" x-show="! photoPreview">
                            @if ($this->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$this->user->profile_photo_path) }}" alt="{{ $this->user->name }}" class="rounded-[2rem] h-28 w-28 object-cover shadow-xl border-4 border-white">
                            @else
                                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-[2rem] h-28 w-28 object-cover shadow-xl border-4 border-white">
                            @endif
                        </div>

                        <div class="mt-2" x-show="photoPreview" style="display: none;">
                            <span class="block rounded-[2rem] h-28 w-28 bg-cover bg-no-repeat bg-center shadow-xl border-4 border-white"
                                  x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>

                        <button type="button" x-on:click.prevent="$refs.photo.click()" class="absolute -bottom-2 -right-2 bg-indigo-600 text-white p-2 rounded-xl shadow-lg hover:bg-indigo-700 transition-all active:scale-90">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>
                    </div>

                    <div class="text-left">
                        <h4 class="text-sm font-black text-gray-800 uppercase tracking-widest">{{ __('Photo') }}</h4>
                        
                        <div class="flex gap-2 mt-3">
                            @if ($this->user->profile_photo_path)
                                <button type="button" class="text-[10px] font-black text-rose-500 uppercase tracking-[0.2em] border border-rose-200 px-3 py-1.5 rounded-lg hover:bg-rose-50 transition-all" wire:click="deleteProfilePhoto">
                                    {{ __('Remove Photo') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="col-span-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            <div class="space-y-2">
                <x-label for="name" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="Name" />
                <x-input id="name" type="text" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all" wire:model="state.name" autocomplete="name" />
                <x-input-error for="name" />
            </div>

            <div class="space-y-2">
                <x-label for="email" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="Email" />
                <x-input id="email" type="email" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all" wire:model="state.email" />
                <x-input-error for="email" />
            </div>

            <div class="space-y-2">
                <x-label for="jenis_kelamin" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="Jenis Kelamin" />
                <select id="jenis_kelamin" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all appearance-none cursor-pointer" wire:model="state.jenis_kelamin">
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <x-input-error for="jenis_kelamin" />
            </div>

            <div class="space-y-2">
                <x-label for="no_telepon" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="No Telepon" />
                <x-input id="no_telepon" type="text" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all" wire:model="state.no_telepon" />
                <x-input-error for="no_telepon" />
            </div>

            <div class="md:col-span-2 space-y-2">
                <x-label for="alamat" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="Alamat" />
                <x-input id="alamat" type="text" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all" wire:model="state.alamat" />
                <x-input-error for="alamat" />
            </div>

            <div class="space-y-2">
                <x-label for="kota" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="Kota" />
                <x-input id="kota" type="text" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all" wire:model="state.kota" />
                <x-input-error for="kota" />
            </div>

            <div class="space-y-2">
                <x-label for="kecamatan" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="Kecamatan" />
                <x-input id="kecamatan" type="text" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all" wire:model="state.kecamatan" />
                <x-input-error for="kecamatan" />
            </div>

            <div class="space-y-2">
                <x-label for="kelurahan" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1" value="Kelurahan" />
                <x-input id="kelurahan" type="text" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all" wire:model="state.kelurahan" />
                <x-input-error for="kelurahan" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-4 text-xs font-black uppercase text-emerald-500 tracking-widest" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <button wire:loading.attr="disabled" wire:target="photo" class="px-10 py-4 bg-gray-900 hover:bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-gray-200 transition-all active:scale-95">
            {{ __('Save') }}
        </button>
    </x-slot>
</x-form-section>