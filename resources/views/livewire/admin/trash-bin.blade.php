<div class="p-8 bg-gray-50 min-h-screen text-left">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6 text-left">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="p-2 bg-rose-100 text-rose-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </span>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Trash <span class="text-rose-600">Bin</span></h1>
            </div>
            <p class="text-gray-600 text-base font-medium">Pusat pemulihan data. Kelola entitas yang telah dihapus untuk dikembalikan atau dimusnahkan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-lg shadow-indigo-100 relative overflow-hidden group">
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-indigo-500 opacity-20 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
            <label class="block text-[10px] font-black text-indigo-100 uppercase tracking-[0.2em] mb-3">Filter Kategori Model</label>
            <div class="relative z-10">
                <select wire:model.live="model" class="w-full bg-indigo-700/50 border-0 focus:ring-2 focus:ring-white text-white rounded-2xl px-6 py-4 text-sm font-black uppercase tracking-widest appearance-none cursor-pointer">
                    @foreach ($models as $label => $class)
                        <option value="{{ $class }}" class="bg-indigo-800">{{ $label }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-indigo-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-sm flex flex-col justify-center text-left">
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Pencarian Cepat</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-6 flex items-center">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" wire:model.live="search" placeholder="CARI BERDASARKAN ID ATAU NAMA DATA..." class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl pl-16 pr-6 py-4 text-xs font-black text-gray-800 tracking-widest uppercase transition-all">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden text-left">
        <div class="overflow-x-auto p-6">
            <table class="w-full text-left border-separate border-spacing-y-4">
                <thead>
                    <tr class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-8 py-2">Informasi Objek</th>
                        <th class="px-8 py-2">Waktu Penghapusan</th>
                        <th class="px-8 py-2 text-right">Aksi Pemulihan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($trashData as $item)
                        <tr class="group transition-all duration-200">
                            <td class="px-8 py-6 bg-gray-50 group-hover:bg-indigo-50/50 rounded-l-[2rem]">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm font-black text-gray-400 text-xs border border-gray-100">
                                        #{{ $item->id }}
                                    </div>
                                    <div>
                                        <div class="text-gray-900 font-black text-base uppercase tracking-tight">
                                            {{ $item->name ?? $item->title ?? 'Untitled Entity' }}
                                        </div>
                                        <div class="text-[10px] text-indigo-500 font-black uppercase tracking-widest mt-1">
                                            Object Reference ID: {{ $item->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 bg-gray-50 group-hover:bg-indigo-50/50">
                                <div class="flex flex-col">
                                    <span class="text-gray-700 font-black text-sm uppercase">{{ $item->deleted_at->format('d M Y') }}</span>
                                    <span class="text-gray-400 font-bold text-[10px] tracking-widest uppercase mt-1">{{ $item->deleted_at->format('H:i') }} WIB</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 bg-gray-50 group-hover:bg-indigo-50/50 rounded-r-[2rem] text-right">
                                <div class="flex justify-end gap-3">
                                    <button wire:click="restore({{ $item->id }})" class="flex items-center gap-2 px-6 py-3 bg-white hover:bg-emerald-600 hover:text-white text-emerald-600 rounded-xl border border-gray-100 transition-all font-black text-[10px] uppercase tracking-widest shadow-sm active:scale-95 group/btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Restore
                                    </button>
                                    <button wire:click="deletePermanent({{ $item->id }})" onclick="return confirm('Peringatan: Data ini akan dihapus permanen!')" class="flex items-center gap-2 px-6 py-3 bg-white hover:bg-rose-600 hover:text-white text-rose-600 rounded-xl border border-gray-100 transition-all font-black text-[10px] uppercase tracking-widest shadow-sm active:scale-95 group/btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Purge
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-24 bg-gray-50 rounded-[2.5rem] text-gray-400 font-black uppercase text-xs tracking-[0.3em] italic">
                                Belum ada data di tempat sampah
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-gray-50 bg-gray-50/50">
            {{ $trashData->links() }}
        </div>
    </div>
</div>