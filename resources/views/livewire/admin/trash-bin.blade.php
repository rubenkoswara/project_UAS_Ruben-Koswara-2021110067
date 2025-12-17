<div class="p-6">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">🗑️ Trash Bin</h1>
        <p class="text-gray-500 text-sm mt-1">
            Kelola data yang telah dihapus — restore atau hapus permanen.
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="text-sm font-medium text-gray-700 mb-1 block">
                    Pilih Model
                </label>

                <select
                    wire:model.live="model"
                    class="w-full text-sm border-gray-300 rounded-lg
                           focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($models as $label => $class)
                        <option value="{{ $class }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700 mb-1 block">
                    Pencarian
                </label>

                <input type="text"
                    wire:model.live="search"
                    placeholder="Cari ID atau nama..."
                    class="w-full text-sm border-gray-300 rounded-lg
                           focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full bg-white">

                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            ID
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Nama / Data Utama
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Dihapus Pada
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($trashData as $item)
                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3 text-sm text-gray-800">
                                {{ $item->id }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-800">
                                {{ $item->name ?? $item->title ?? '[Tidak Ada Nama]' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $item->deleted_at->format('d M Y H:i') }}
                            </td>

                            <td class="px-4 py-3 text-center space-x-2">
                                <button
                                    wire:click="restore({{ $item->id }})"
                                    class="px-3 py-1.5 text-xs rounded-lg shadow
                                           bg-indigo-600 text-white hover:bg-indigo-700">
                                    Restore
                                </button>
                                <button
                                    wire:click="deletePermanent({{ $item->id }})"
                                    class="px-3 py-1.5 text-xs rounded-lg shadow
                                           bg-red-600 text-white hover:bg-red-700">
                                    Hapus Permanen
                                </button>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="4" class="px-4 py-6 text-sm text-center text-gray-500">
                                Tidak ada data di Trash Bin.
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $trashData->links() }}
        </div>
    </div>
</div>
