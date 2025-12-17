<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">

        {{-- FIELD NAME --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="Name" />
            <x-input id="name" type="text" class="mt-1 block w-full"
                     wire:model="state.name" autocomplete="name"/>
            <x-input-error for="name" class="mt-2" />
        </div>

        {{-- FIELD EMAIL --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="Email" />
            <x-input id="email" type="email" class="mt-1 block w-full"
                     wire:model="state.email" />
            <x-input-error for="email" class="mt-2" />
        </div>

        {{-- FIELD LAIN TETAP --}}
        {{-- Jenis Kelamin --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="jenis_kelamin" value="Jenis Kelamin" />
            <select id="jenis_kelamin" class="mt-1 block w-full"
                    wire:model="state.jenis_kelamin">
                <option value="">Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <x-input-error for="jenis_kelamin" class="mt-2" />
        </div>

        {{-- Alamat --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="alamat" value="Alamat" />
            <x-input id="alamat" type="text" class="mt-1 block w-full"
                     wire:model="state.alamat" />
            <x-input-error for="alamat" class="mt-2" />
        </div>

        {{-- Kota --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="kota" value="Kota" />
            <x-input id="kota" type="text" class="mt-1 block w-full"
                     wire:model="state.kota" />
            <x-input-error for="kota" class="mt-2" />
        </div>

        {{-- Kecamatan --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="kecamatan" value="Kecamatan" />
            <x-input id="kecamatan" type="text" class="mt-1 block w-full"
                     wire:model="state.kecamatan" />
            <x-input-error for="kecamatan" class="mt-2" />
        </div>

        {{-- Kelurahan --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="kelurahan" value="Kelurahan" />
            <x-input id="kelurahan" type="text" class="mt-1 block w-full"
                     wire:model="state.kelurahan" />
            <x-input-error for="kelurahan" class="mt-2" />
        </div>

        {{-- No Telepon --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="no_telepon" value="No Telepon" />
            <x-input id="no_telepon" type="text" class="mt-1 block w-full"
                     wire:model="state.no_telepon" />
            <x-input-error for="no_telepon" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">Saved.</x-action-message>
        <x-button wire:loading.attr="disabled" wire:target="photo">
            Save
        </x-button>
    </x-slot>
</x-form-section>
