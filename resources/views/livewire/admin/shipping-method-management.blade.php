<div class="p-8 bg-gray-50 min-h-screen text-left">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Jasa <span class="text-blue-600">Pengiriman</span></h1>
            <p class="text-gray-600 text-base font-medium mt-2">Atur opsi kurir dan standarisasi biaya pengiriman logistik Anda.</p>
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
                <h3 class="text-xs font-black text-blue-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    {{ $updateMode ? 'Update Kurir' : 'Kurir Baru' }}
                </h3>
                
                <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Layanan Kurir</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all uppercase placeholder:normal-case" placeholder="CONTOH: JNE REGULER">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Ongkos Kirim (IDR)</label>
                        <div class="relative">
                            <span class="absolute left-6 inset-y-0 flex items-center text-xs font-black text-gray-400">RP</span>
                            <input type="number" wire:model="cost" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-2xl pl-14 pr-6 py-4 text-sm font-black text-gray-800 transition-all" placeholder="0">
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 pt-4">
                        <button type="submit" class="w-full py-4 bg-gray-900 hover:bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg transition-all active:scale-95">
                            {{ $updateMode ? 'Perbarui Data' : 'Simpan Kurir' }}
                        </button>

                        @if($updateMode)
                            <button type="button" wire:click="resetInput" class="w-full py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                                Batal
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden text-left">
                <div class="p-8 border-b border-gray-50 bg-white/50 backdrop-blur-sm">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-6 flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" wire:model.live="search" placeholder="CARI KURIR..." class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-2xl pl-16 pr-6 py-4 text-xs font-black text-gray-800 tracking-widest uppercase transition-all">
                    </div>
                </div>

                <div class="overflow-x-auto p-6 text-left">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-gray-400 text-[10px] font-black uppercase tracking-widest">
                                <th class="px-6 py-2">Kurir</th>
                                <th class="px-6 py-2 text-right">Ongkos Kirim</th>
                                <th class="px-6 py-2 text-center">Status</th>
                                <th class="px-6 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($methods as $method)
                                <tr class="group transition-all duration-200 text-left">
                                    <td class="px-6 py-5 bg-gray-50 group-hover:bg-blue-50/50 rounded-l-[1.5rem]">
                                        <div class="flex items-center gap-4 text-left">
                                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-blue-600 font-black text-[10px]">
                                                {{ substr($method->name, 0, 2) }}
                                            </div>
                                            <div class="text-left">
                                                <div class="text-gray-900 font-black text-base uppercase tracking-tight">{{ $method->name }}</div>
                                                <div class="text-gray-400 font-bold text-[10px] tracking-widest uppercase">ID: #SHP-{{ $method->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 bg-gray-50 group-hover:bg-blue-50/50 text-right font-black text-gray-900">
                                        Rp {{ number_format($method->cost, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5 bg-gray-50 group-hover:bg-blue-50/50 text-center">
                                        @if($method->trashed())
                                            <span class="px-4 py-1.5 bg-rose-50 text-rose-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-rose-100">Suspend</span>
                                        @else
                                            <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-emerald-100">Active</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 bg-gray-50 group-hover:bg-blue-50/50 rounded-r-[1.5rem] text-right">
                                        <div class="flex justify-end gap-2">
                                            <button wire:click="edit({{ $method->id }})" class="p-3 bg-white hover:bg-amber-50 text-amber-500 rounded-xl border border-gray-100 transition-all active:scale-90 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>

                                            @if(!$method->trashed())
                                                <button wire:click="delete({{ $method->id }})" onclick="return confirm('Nonaktifkan kurir ini?')" class="p-3 bg-white hover:bg-rose-50 text-rose-500 rounded-xl border border-gray-100 transition-all active:scale-90 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            @else
                                                <button wire:click="restore({{ $method->id }})" class="p-3 bg-white hover:bg-emerald-50 text-emerald-500 rounded-xl border border-gray-100 transition-all active:scale-90 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-20 bg-gray-50 rounded-[2rem] text-gray-400 font-black uppercase text-xs italic tracking-widest">
                                        Layanan pengiriman tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-8 border-t border-gray-50 bg-gray-50/50">
                    {{ $methods->links() }}
                </div>
            </div>
        </div>
    </div>
</div>