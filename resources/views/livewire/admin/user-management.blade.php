<div class="p-6">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kelola User</h1>
        <p class="text-sm text-gray-500 mt-1">Manajemen user, role, dan akses sistem.</p>
    </div>

    @if(session('message'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 mb-4 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-5">
        <input type="text" wire:model.live="search"
            class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg p-2 w-1/3 text-sm"
            placeholder="Cari user...">

        <button wire:click="createUser"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg shadow text-sm">
            + Tambah User
        </button>
    </div>

    <div class="bg-white border rounded-xl shadow overflow-hidden">

        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->email }}</td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-white text-xs
                                {{ $user->role === 'admin' ? 'bg-purple-600' : 'bg-green-600' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">

                                {{-- Edit --}}
                                <button wire:click="editUser({{ $user->id }})"
                                    class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow text-xs">
                                    Edit
                                </button>

                                {{-- Reset Password --}}
                                <button wire:click="openResetPasswordModal({{ $user->id }})"
                                    class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow text-xs">
                                    Reset Password
                                </button>

                                {{-- Delete --}}
                                <button wire:click="deleteUser({{ $user->id }})"
                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow text-xs">
                                    Hapus
                                </button>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500 text-sm">
                            Tidak ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>

    @if($modal)
    <div class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50">

        <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg">

            <h3 class="text-xl font-bold mb-4 text-gray-800">
                {{ $user_id ? 'Edit User' : 'Tambah User' }}
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" wire:model="name"
                        class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                    @error('name') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="email"
                        class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                    @error('email') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
                </div>

                @if(!$user_id)
                <div>
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    <input type="password" wire:model="password"
                        class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                    <p class="text-xs text-gray-500">Minimal 6 karakter</p>
                </div>
                @endif

                <div>
                    <label class="text-sm font-medium text-gray-700">Role</label>
                    <select wire:model="role"
                        class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-2">
                <button wire:click="closeModal"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">
                    Batal
                </button>

                <button wire:click="saveUser"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">
                    Simpan
                </button>
            </div>

        </div>
    </div>
    @endif

    @if($resetPasswordModal)
    <div class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50">

        <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg">

            <h3 class="text-xl font-bold mb-4 text-gray-800">Reset Password</h3>

            <div>
                <label class="text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" wire:model="password"
                    class="border-gray-300 p-2 w-full rounded-lg focus:ring-indigo-400 focus:border-indigo-400 text-sm">

                @error('password')
                    <p class="text-red-600 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5 flex justify-end gap-2">
                <button wire:click="closeResetPasswordModal"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">
                    Batal
                </button>

                <button wire:click="saveResetPassword"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">
                    Reset
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
