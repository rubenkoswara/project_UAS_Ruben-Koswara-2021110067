<div class="p-6 max-w-6xl mx-auto space-y-6">
    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Manajemen Metode Pembayaran</h2>

    @if(session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-600 text-green-700 px-4 py-3 rounded shadow">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
        <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="grid gap-4">

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Metode</label>
                <input type="text" wire:model="name"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full 
                           focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Bank</label>
                <input type="text" wire:model="bank_name"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full 
                           focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">No Rekening</label>
                <input type="text" wire:model="account_number"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full 
                           focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Atas Nama</label>
                <input type="text" wire:model="account_name"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full 
                           focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md font-medium">
                    {{ $updateMode ? 'Update' : 'Simpan' }}
                </button>

                @if($updateMode)
                    <button type="button" wire:click="resetInput"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg shadow-md font-medium">
                        Batal
                    </button>
                @endif
            </div>

        </form>
    </div>

    <div>
        <input type="text" wire:model="search"
            placeholder="Cari metode..."
            class="border border-gray-300 rounded-xl px-4 py-2 w-full shadow-sm
                   focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 border-b text-gray-700 text-sm uppercase font-medium">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Bank</th>
                    <th class="px-4 py-3">No Rekening</th>
                    <th class="px-4 py-3">Atas Nama</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">
                @foreach($methods as $method)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3">{{ $method->id }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $method->name }}</td>
                        <td class="px-4 py-3">{{ $method->bank_name }}</td>
                        <td class="px-4 py-3">{{ $method->account_number }}</td>
                        <td class="px-4 py-3">{{ $method->account_name }}</td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center items-center gap-2">

                                {{-- EDIT --}}
                                <button wire:click="edit({{ $method->id }})"
                                    class="px-3 py-1 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white text-sm shadow">
                                    Edit
                                </button>

                                {{-- DELETE / RESTORE --}}
                                @if(!$method->trashed())
                                    <button wire:click="delete({{ $method->id }})"
                                        class="px-3 py-1 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm shadow">
                                        Hapus
                                    </button>
                                @else
                                    <button wire:click="restore({{ $method->id }})"
                                        class="px-3 py-1 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm shadow">
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
        {{ $methods->links() }}
    </div>

</div>
