<div class="p-6">

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-500 text-white rounded-md shadow">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Produk</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua produk, kategori, brand, dan vendor di sini.</p>
    </div>

    <div class="flex justify-end items-center mb-5">
        <button wire:click="openModal"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow text-sm">
            + Tambah Produk
        </button>
    </div>

    <div class="bg-white border rounded-xl shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <select wire:model.live="filterCategory" class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg p-2 text-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterBrand" class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg p-2 text-sm">
                <option value="">Semua Brand</option>
                @foreach ($brands as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterVendor" class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg p-2 text-sm">
                <option value="">Semua Vendor</option>
                @foreach ($vendors as $v)
                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
            </select>

        </div>
    </div>

    <div class="bg-white border rounded-xl shadow overflow-hidden">

        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Brand</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Vendor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($products as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            @if ($p->image)
                                <img src="{{ asset('storage/' . $p->image) }}"
                                class="h-12 w-12 rounded-lg object-cover shadow-sm cursor-pointer"
                                wire:click="openImageModal('{{ asset('storage/' . $p->image) }}')">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-800">{{ $p->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $p->category->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $p->brand->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $p->vendor->name }}</td>

                        <td class="px-4 py-3 text-sm text-gray-800">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $p->stock }}</td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <button wire:click="edit({{ $p->id }})"
                                    class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow text-xs">
                                    Edit
                                </button>

                                <button wire:click="delete({{ $p->id }})"
                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow text-xs"
                                    onclick="return confirm('Hapus produk ini?')">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500 text-sm">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50">

            <div class="bg-white w-full max-w-3xl p-6 rounded-xl shadow-lg">

                <button wire:click="closeModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>

                <h2 class="text-xl font-bold mb-4 text-gray-800">
                    {{ $isEdit ? 'Edit Produk' : 'Tambah Produk' }}
                </h2>

                <div class="space-y-4">

                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" wire:model="name"
                            class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm"
                            placeholder="Nama Produk">
                        @error('name') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea wire:model="description" rows="6"
                            class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm"
                            placeholder="Deskripsi"></textarea>
                        @error('description') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Kategori</label>
                            <select wire:model="category_id" class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Brand</label>
                            <select wire:model="brand_id" class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                                <option value="">Pilih Brand</option>
                                @foreach ($brands as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Vendor</label>
                            <select wire:model="vendor_id" class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                                <option value="">Pilih Vendor</option>
                                @foreach ($vendors as $v)
                                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                                @endforeach
                            </select>
                            @error('vendor_id') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" wire:model="price" class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm"
                                placeholder="Harga">
                            @error('price') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" wire:model="stock" class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm"
                                placeholder="Stock">
                            @error('stock') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Gambar</label>
                        <input type="file" wire:model="image" class="mt-1 border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                        @error('image') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror

                        <div wire:loading wire:target="image" class="text-blue-500 mt-2">
                            Uploading...
                        </div>

                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="h-32 mt-3 rounded-lg shadow">
                        @elseif ($oldImage)
                            <img src="{{ asset('storage/' . $oldImage) }}" class="h-32 mt-3 rounded-lg shadow">
                        @endif
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-2">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">
                        Batal
                    </button>

                    @if ($isEdit)
                        <button wire:click="update"
                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">
                            Update
                        </button>
                    @else
                        <button wire:click="store"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">
                            Simpan
                        </button>
                    @endif
                </div>

            </div>

        </div>
    @endif

    @if ($showImageModal)
        <div class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center z-50 p-4"
            wire:click.self="closeImageModal">
            <div class="bg-white rounded-lg shadow-xl max-w-3xl max-h-[90vh] overflow-hidden relative">
                <button wire:click="closeImageModal"
                    class="absolute top-2 right-2 bg-gray-800 text-white rounded-full p-2 text-xl leading-none hover:bg-gray-700 transition">
                    &times;
                </button>
                <img src="{{ $selectedImageUrl }}" alt="Enlarged Product Image"
                    class="max-w-full max-h-[85vh] object-contain mx-auto">
            </div>
        </div>
    @endif

</div>

