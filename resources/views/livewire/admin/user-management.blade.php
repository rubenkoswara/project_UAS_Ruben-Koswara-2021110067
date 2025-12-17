<div class="p-8 bg-gray-50 min-h-screen text-left">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Otoritas <span class="text-indigo-600">Pengguna</span></h1>
            <p class="text-gray-600 text-base font-medium mt-2">Kendalikan hak akses, peran, dan keamanan kredensial seluruh pengguna sistem.</p>
        </div>
        <button wire:click="createUser" class="flex items-center justify-center gap-3 bg-gray-900 hover:bg-indigo-600 text-white px-8 py-4 rounded-2xl shadow-xl shadow-gray-200 transition-all active:scale-95 group">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            <span class="text-xs font-black uppercase tracking-[0.1em]">Tambah User Baru</span>
        </button>
    </div>

    @if(session('message'))
        <div class="mb-8 p-5 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-900 rounded-r-2xl flex items-center gap-3 shadow-sm animate-pulse">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-black uppercase tracking-widest">{{ session('message') }}</span>
        </div>
    @endif

    <div class="mb-8 relative max-w-xl">
        <span class="absolute inset-y-0 left-6 flex items-center">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        <input type="text" wire:model.live="search" placeholder="CARI BERDASARKAN NAMA ATAU EMAIL..." class="w-full bg-white border-0 focus:ring-2 focus:ring-indigo-500 rounded-[1.5rem] pl-16 pr-6 py-5 text-xs font-black text-gray-800 tracking-widest uppercase shadow-sm transition-all">
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto p-6">
            <table class="w-full text-left border-separate border-spacing-y-4">
                <thead>
                    <tr class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-6 py-2">Informasi Identitas</th>
                        <th class="px-6 py-2">Hak Akses</th>
                        <th class="px-6 py-2 text-center">Tindakan Keamanan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($users as $user)
                        <tr class="group transition-all duration-200">
                            <td class="px-6 py-6 bg-gray-50 group-hover:bg-indigo-50/50 rounded-l-[1.5rem]">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center font-black text-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-gray-900 font-black text-base uppercase tracking-tight">{{ $user->name }}</div>
                                        <div class="text-gray-500 font-bold text-xs">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 bg-gray-50 group-hover:bg-indigo-50/50">
                                <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-600 border-purple-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-6 bg-gray-50 group-hover:bg-indigo-50/50 rounded-r-[1.5rem]">
                                <div class="flex justify-center gap-3">
                                    <button wire:click="editUser({{ $user->id }})" class="p-3 bg-white hover:bg-indigo-600 hover:text-white text-indigo-600 rounded-xl border border-gray-100 transition-all shadow-sm active:scale-90" title="Edit Profil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="openResetPasswordModal({{ $user->id }})" class="p-3 bg-white hover:bg-amber-500 hover:text-white text-amber-500 rounded-xl border border-gray-100 transition-all shadow-sm active:scale-90" title="Reset Password">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    </button>
                                    <button wire:click="deleteUser({{ $user->id }})" class="p-3 bg-white hover:bg-rose-600 hover:text-white text-rose-600 rounded-xl border border-gray-100 transition-all shadow-sm active:scale-90" title="Hapus User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-20 bg-gray-50 rounded-[2rem] text-gray-400 font-black uppercase text-xs tracking-[0.2em]">Data User Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-gray-50 bg-gray-50/50">
            {{ $users->links() }}
        </div>
    </div>

    @if($modal)
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 text-left">
                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight mb-8">
                    {{ $user_id ? 'Perbarui Profil' : 'Daftarkan User Baru' }}
                </h3>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all">
                        @error('name') <p class="mt-2 ml-1 text-rose-500 text-[10px] font-black uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                        <input type="email" wire:model="email" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all">
                        @error('email') <p class="mt-2 ml-1 text-rose-500 text-[10px] font-black uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    @if(!$user_id)
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Password Sistem</label>
                        <input type="password" wire:model="password" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all">
                    </div>
                    @endif

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Peran / Role</label>
                        <select wire:model="role" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-indigo-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all appearance-none">
                            <option value="customer text-left">CUSTOMER (PELANGGAN)</option>
                            <option value="admin text-left">ADMINISTRATOR</option>
                        </select>
                    </div>
                </div>

                <div class="mt-10 flex gap-4">
                    <button wire:click="closeModal" class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">Batal</button>
                    <button wire:click="saveUser" class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 transition-all active:scale-95">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($resetPasswordModal)
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden text-left">
            <div class="p-10">
                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight mb-2">Reset Password</h3>
                <p class="text-gray-500 text-xs font-bold mb-8 tracking-wide italic">Gunakan password yang kuat untuk keamanan akun.</p>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Password Baru</label>
                        <input type="password" wire:model="password" class="w-full bg-gray-50 border-0 focus:ring-2 focus:ring-amber-500 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 transition-all">
                        @error('password') <p class="mt-2 ml-1 text-rose-500 text-[10px] font-black uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-10 flex gap-4 text-left">
                    <button wire:click="closeResetPasswordModal" class="flex-1 py-4 bg-gray-100 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">Batal</button>
                    <button wire:click="saveResetPassword" class="flex-1 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-amber-100 transition-all active:scale-95">Update</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>