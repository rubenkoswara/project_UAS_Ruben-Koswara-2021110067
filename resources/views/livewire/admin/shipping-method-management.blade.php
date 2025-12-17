<div class="p-6 bg-gray-100 min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Manajemen Jasa Kirim</h2>

    @if(session()->has('message'))
        <div class="bg-green-100 text-green-800 border border-green-300 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow border border-gray-200 p-6 mb-6">
        <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="space-y-4">

            <div>
                <label class="font-medium text-gray-700 text-sm">Nama Kurir</label>
                <input type="text" wire:model="name"
                       class="border border-gray-300 rounded-lg w-full p-2 mt-1 text-sm bg-white focus:ring-2 focus:ring-blue-300 focus:outline-none"
                       placeholder="Contoh: JNE, J&T, SiCepat">
            </div>

            <div>
                <label class="font-medium text-gray-700 text-sm">Ongkos Kirim</label>
                <input type="number" wire:model="cost"
                       class="border border-gray-300 rounded-lg w-full p-2 mt-1 text-sm bg-white focus:ring-2 focus:ring-blue-300 focus:outline-none"
                       placeholder="Masukkan biaya pengiriman">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                    {{ $updateMode ? 'Update' : 'Simpan' }}
                </button>

                @if($updateMode)
                    <button type="button" wire:click="resetInput"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                        Batal
                    </button>
                @endif
            </div>

        </form>
    </div>

    <input type="text" wire:model.live="search"
           class="border border-gray-300 p-2 rounded-lg w-full mb-5 bg-white shadow-sm text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none"
           placeholder="Cari nama kurir...">

    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama Kurir</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Ongkir</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($methods as $method)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $method->id }}</td>
                        <td class="px-4 py-3">{{ $method->name }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($method->cost) }}</td>

                        <td class="px-4 py-3">
                            @if($method->trashed())
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs">Tidak Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs">Aktif</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 space-x-2">
                            <button wire:click="edit({{ $method->id }})"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                                Edit
                            </button>

                            @if(!$method->trashed())
                                <button wire:click="delete({{ $method->id }})"
                                        onclick="return confirm('Yakin hapus?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs shadow">
                                    Hapus
                                </button>
                            @endif

                            @if($method->trashed())
                                <button wire:click="restore({{ $method->id }})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs shadow">
                                    Pulihkan
                                </button>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-gray-50 border-t">
            {{ $methods->links() }}
        </div>
    </div>
</div>
