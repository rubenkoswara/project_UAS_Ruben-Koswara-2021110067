<div class="p-6 max-w-5xl mx-auto font-sans">

    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Manajemen Vendor</h2>

    @if(session()->has('message'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 text-green-700 border border-green-200 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}"
        class="mb-6 bg-white p-6 rounded-xl shadow-lg border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-4">

        <input type="text" wire:model="name"
            placeholder="Nama Vendor"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-blue-300 focus:ring">

        <input type="text" wire:model="address"
            placeholder="Alamat Vendor"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-blue-300 focus:ring">

        <input type="text" wire:model="phone"
            placeholder="No Telepon"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-blue-300 focus:ring">

        <div class="flex gap-3 col-span-2 mt-2">
            <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all">
                {{ $updateMode ? 'Update' : 'Simpan' }}
            </button>

            @if($updateMode)
            <button wire:click="resetInput"
                class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-md transition-all">
                Batal
            </button>
            @endif
        </div>
    </form>

    <input type="text" wire:model="search"
        placeholder="Cari vendor..."
        class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:border-blue-500 focus:ring-blue-300 focus:ring">

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-x-auto">
        <table class="w-full text-gray-700">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Alamat</th>
                    <th class="px-4 py-3 text-left">Telepon</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($vendors as $vendor)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3">{{ $vendor->id }}</td>
                    <td class="px-4 py-3">{{ $vendor->name }}</td>
                    <td class="px-4 py-3">{{ $vendor->address }}</td>
                    <td class="px-4 py-3">{{ $vendor->phone }}</td>

                    <td class="px-4 py-3">
                        <div class="flex gap-2 justify-center">

                            <button wire:click="edit({{ $vendor->id }})"
                                class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow transition">
                                Edit
                            </button>

                            @if(!$vendor->trashed())
                                <button wire:click="delete({{ $vendor->id }})"
                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow transition">
                                    Hapus
                                </button>
                            @else
                                <button wire:click="restore({{ $vendor->id }})"
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition">
                                    Pulihkan
                                </button>
                            @endif

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-4">
        {{ $vendors->links() }}
    </div>

</div>
