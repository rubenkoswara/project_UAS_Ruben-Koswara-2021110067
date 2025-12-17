<div class="p-8 bg-gray-50 min-h-screen text-left">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Manajemen <span class="text-indigo-600">Kategori</span></h1>
            <p class="text-gray-600 text-base font-medium mt-2">Kelola struktur klasifikasi produk Anda dalam satu panel kontrol.</p>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="mb-6 p-5 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-900 rounded-r-2xl flex items-center gap-3 shadow-sm">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-sm font-black uppercase tracking-widest">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm sticky top-24">
                <h3 class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $updateMode ? 'Update Kategori' : 'Kategori Baru' }}
                </h3>
                
                <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Kategori</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all uppercase placeholder:normal-case" placeholder="Contoh: Aksesoris Aquarium">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Deskripsi Singkat</label>
                        <textarea wire:model="description" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 h-32 transition-all" placeholder="Jelaskan isi kategori ini..."></textarea>
                    </div>

                    <div class="flex flex-col gap-3 pt-4">
                        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 transition-all active:scale-95">
                            {{ $updateMode ? 'Simpan Perubahan' : 'Tambahkan Kategori' }}
                        </button>

                        @if($updateMode)
                            <button type="button" wire:click="resetInput" class="w-full py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                                Batalkan Edit
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-gray-50 bg-white/50 backdrop-blur-sm">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-6 flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" wire:model.live="search" placeholder="CARI NAMA KATEGORI..." class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl pl-16 pr-6 py-4 text-xs font-black text-gray-800 tracking-widest uppercase transition-all">
                    </div>
                </div>

                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-gray-400 text-[10px] font-black uppercase tracking-widest">
                                <th class="px-6 py-2">ID</th>
                                <th class="px-6 py-2">Informasi Kategori</th>
                                <th class="px-6 py-2 text-center">Aksi Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($categories as $cat)
                                <tr class="group transition-all duration-200">
                                    <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50 rounded-l-[1.5rem] w-20">
                                        <span class="text-gray-400 font-black text-xs">#{{ $cat->id }}</span>
                                    </td>
                                    <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50">
                                        <div class="text-gray-900 font-black text-base uppercase tracking-tight mb-1">{{ $cat->name }}</div>
                                        <div class="text-gray-500 font-bold text-[11px] leading-relaxed line-clamp-1 italic">{{ $cat->description ?: 'Tidak ada deskripsi' }}</div>
                                    </td>
                                    <td class="px-6 py-5 bg-gray-50 group-hover:bg-indigo-50/50 rounded-r-[1.5rem] text-center w-56">
                                        <div class="flex justify-center gap-3">
                                            <button wire:click="edit({{ $cat->id }})" class="p-3 bg-white hover:bg-amber-50 text-amber-500 rounded-xl border border-gray-100 hover:border-amber-200 transition-all active:scale-90 shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>

                                            @if(!$cat->trashed())
                                                <button wire:click="delete({{ $cat->id }})" class="p-3 bg-white hover:bg-rose-50 text-rose-500 rounded-xl border border-gray-100 hover:border-rose-200 transition-all active:scale-90 shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            @else
                                                <button wire:click="restore({{ $cat->id }})" class="p-3 bg-white hover:bg-emerald-50 text-emerald-500 rounded-xl border border-gray-100 hover:border-emerald-200 transition-all active:scale-90 shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-20 bg-gray-50 rounded-[2rem] text-gray-400 font-black uppercase text-xs italic tracking-widest">
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-8 border-t border-gray-50 bg-gray-50/50">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>