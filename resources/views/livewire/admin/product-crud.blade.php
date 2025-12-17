<div class="p-8 bg-gray-50 min-h-screen text-left">
    <style>
        @keyframes modalEntry {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal {
            animation: modalEntry 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { bg: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Manajemen <span class="text-blue-600">Produk</span></h1>
            <p class="text-gray-500 text-sm font-medium mt-1">Kelola stok dan klasifikasi produk Anda dengan mudah.</p>
        </div>
        <button wire:click="openModal" class="px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-lg shadow-blue-100 transition-all transform hover:-translate-y-1 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            <span class="text-xs font-black uppercase tracking-widest">Tambah Produk</span>
        </button>
    </div>

    <div class="bg-white p-4 rounded-[2.5rem] border border-gray-100 shadow-sm mb-10">
        <div class="flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1 w-full group">
                <div class="relative flex items-center">
                    <div class="absolute left-5 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </div>
                    <select wire:model.live="filterCategory" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-100 rounded-[1.5rem] pl-12 pr-5 py-4 text-[10px] font-black uppercase tracking-widest text-gray-600 appearance-none transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-1 w-full group">
                <div class="relative flex items-center">
                    <div class="absolute left-5 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <select wire:model.live="filterBrand" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-100 rounded-[1.5rem] pl-12 pr-5 py-4 text-[10px] font-black uppercase tracking-widest text-gray-600 appearance-none transition-all">
                        <option value="">Semua Merek</option>
                        @foreach ($brands as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-1 w-full group">
                <div class="relative flex items-center">
                    <div class="absolute left-5 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <select wire:model.live="filterVendor" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-100 rounded-[1.5rem] pl-12 pr-5 py-4 text-[10px] font-black uppercase tracking-widest text-gray-600 appearance-none transition-all">
                        <option value="">Semua Vendor</option>
                        @foreach ($vendors as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <button wire:click="$set('filterCategory', ''), $set('filterBrand', ''), $set('filterVendor', '')" class="p-4 text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden animate-fade-in">
        <div class="overflow-x-auto p-6">
            <table class="w-full text-left border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-6 py-2">Produk</th>
                        <th class="px-6 py-2 text-center">Kategori</th>
                        <th class="px-6 py-2 text-center">Merek</th>
                        <th class="px-6 py-2 text-center">Stok</th>
                        <th class="px-6 py-2">Harga</th>
                        <th class="px-6 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-bold text-gray-600">
                    @forelse ($products as $p)
                        <tr class="group transition-all duration-300">
                            <td class="px-6 py-4 bg-gray-50 group-hover:bg-blue-50/50 first:rounded-l-[1.5rem] transition-colors">
                                <div class="flex items-center gap-4">
                                    @if ($p->image)
                                        <img src="{{ asset('storage/' . $p->image) }}" class="h-12 w-12 rounded-xl object-cover shadow-sm ring-2 ring-white">
                                    @else
                                        <div class="h-12 w-12 rounded-xl bg-gray-200 flex items-center justify-center text-[8px] text-gray-400 uppercase font-black">N/A</div>
                                    @endif
                                    <div>
                                        <p class="text-gray-900 font-black uppercase tracking-tight leading-none text-xs">{{ $p->name }}</p>
                                        <p class="text-[9px] text-blue-500 font-black uppercase tracking-widest mt-1">#{{ $p->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 bg-gray-50 group-hover:bg-blue-50/50 text-center transition-colors text-xs font-black uppercase tracking-tight text-gray-400">{{ $p->category->name }}</td>
                            <td class="px-6 py-4 bg-gray-50 group-hover:bg-blue-50/50 text-center transition-colors text-xs font-black uppercase tracking-tight text-gray-400">{{ $p->brand->name }}</td>
                            <td class="px-6 py-4 bg-gray-50 group-hover:bg-blue-50/50 text-center transition-colors">
                                <span class="text-gray-900 font-black text-xs px-3 py-1 bg-white rounded-lg shadow-sm border border-gray-100">{{ $p->stock }}</span>
                            </td>
                            <td class="px-6 py-4 bg-gray-50 group-hover:bg-blue-50/50 transition-colors">
                                <p class="text-gray-900 font-black tracking-tight text-xs">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4 bg-gray-50 group-hover:bg-blue-50/50 last:rounded-r-[1.5rem] transition-colors text-center">
                                <div class="flex justify-center gap-2">
                                    <button wire:click="edit({{ $p->id }})" class="p-2.5 bg-white text-blue-600 rounded-xl shadow-sm border border-gray-100 hover:bg-blue-600 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="delete({{ $p->id }})" onclick="return confirm('Hapus produk ini?')" class="p-2.5 bg-white text-red-600 rounded-xl shadow-sm border border-gray-100 hover:bg-red-600 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-20 text-gray-400 text-[10px] font-black tracking-[0.3em] uppercase italic">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-md flex justify-center items-center z-[100] p-4 overflow-hidden">
            <div class="bg-gray-50 w-full max-w-5xl h-fit max-h-[90vh] rounded-[3rem] shadow-2xl relative border border-white flex flex-col animate-modal overflow-hidden">
                
                <div class="p-8 flex justify-between items-center bg-white/80 backdrop-blur-sm border-b border-gray-100 rounded-t-[3rem]">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-50 rounded-xl">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.828 2.828 0 114 4L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $isEdit ? 'Update' : 'Registrasi' }} <span class="text-blue-600">Produk</span></h2>
                        </div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1 ml-11">Silahkan isi detail data logistik dibawah ini.</p>
                    </div>
                    <button wire:click="closeModal" class="p-4 bg-gray-50 rounded-2xl hover:bg-red-50 hover:text-red-600 transition-all active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar flex-1">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm space-y-6">
                                <div class="grid grid-cols-1 gap-6">
                                    <div class="group">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Informasi Utama</label>
                                        <input type="text" wire:model="name" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-500/20 rounded-2xl p-5 text-sm font-bold text-gray-700 placeholder:text-gray-300 transition-all" placeholder="Masukkan nama lengkap produk...">
                                    </div>
                                    <div class="group">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Spesifikasi & Deskripsi</label>
                                        <textarea wire:model="description" rows="4" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-500/20 rounded-2xl p-5 text-sm font-bold text-gray-700 placeholder:text-gray-300 transition-all" placeholder="Jelaskan detail produk..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="group">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Harga Satuan (Rp)</label>
                                        <div class="relative flex items-center">
                                            <span class="absolute left-5 font-black text-gray-400">Rp</span>
                                            <input type="number" wire:model="price" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-500/20 rounded-2xl p-5 pl-12 text-sm font-bold text-gray-700 transition-all">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Stok Inventaris</label>
                                        <input type="number" wire:model="stock" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-500/20 rounded-2xl p-5 text-sm font-bold text-gray-700 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm space-y-6">
                                <div class="group">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Klasifikasi Kategori</label>
                                    <select wire:model="category_id" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-500/20 rounded-2xl p-5 text-sm font-bold text-gray-700 appearance-none">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="group">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Identitas Merek</label>
                                    <select wire:model="brand_id" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-blue-500/20 rounded-2xl p-5 text-sm font-bold text-gray-700 appearance-none">
                                        <option value="">Pilih Brand</option>
                                        @foreach ($brands as $b)
                                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm text-center">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-4">Preview Media</label>
                                <div class="relative group mx-auto h-48 w-full bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden transition-all hover:border-blue-300">
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                    @elseif ($oldImage)
                                        <img src="{{ asset('storage/' . $oldImage) }}" class="absolute inset-0 w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-tighter">Click to Upload</span>
                                    @endif
                                    <input type="file" wire:model="image" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="p-8 bg-white border-t border-gray-100 rounded-b-[3rem] flex gap-4">
                    <button wire:click="closeModal" class="flex-1 py-5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-400 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all">Batalkan Perubahan</button>
                    <button wire:click="{{ $isEdit ? 'update' : 'store' }}" class="flex-[1.5] py-5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-blue-100 transition-all transform active:scale-95">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Finalisasi Produk' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>