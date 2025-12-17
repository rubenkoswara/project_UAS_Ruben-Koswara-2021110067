<div class="p-6 max-w-6xl mx-auto space-y-6">

    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Manajemen Kategori</h2>

    @if(session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-600 text-green-700 px-4 py-3 rounded shadow">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
        <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="grid gap-4">

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Kategori</label>
                <input type="text" wire:model="name"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                <textarea wire:model="description"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full h-24 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md font-medium">
                    {{ $updateMode ? 'Update' : 'Simpan' }}
                </button>

                @if($updateMode)
                    <button wire:click="resetInput"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg shadow-md font-medium">
                        Batal
                    </button>
                @endif
            </div>
        </form>
    </div>

    <div>
        <input type="text" wire:model="search"
            placeholder="Cari kategori..."
            class="border border-gray-300 rounded-xl px-4 py-2 w-full shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 border-b text-gray-700 text-sm uppercase font-medium">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">
                @foreach($categories as $cat)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $cat->id }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $cat->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $cat->description }}</td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center items-center gap-2">

                                <button wire:click="edit({{ $cat->id }})"
                                    class="px-3 py-1 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white text-sm shadow">
                                    Edit
                                </button>

                                @if(!$cat->trashed())
                                    <button wire:click="delete({{ $cat->id }})"
                                        class="px-3 py-1 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm shadow">
                                        Hapus
                                    </button>
                                @else
                                    <button wire:click="restore({{ $cat->id }})"
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
        {{ $categories->links() }}
    </div>
</div>
