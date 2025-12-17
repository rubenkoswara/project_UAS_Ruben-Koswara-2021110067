<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome + Tanggal & Jam --}}
            <div class="bg-gradient-to-r from-blue-400 to-indigo-500 text-white rounded-xl shadow-lg p-6 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="text-3xl">👋</div>
                    <div>
                        <h3 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}</h3>
                        <p class="mt-1 text-white/90">This is the Renesca Aquatic admin dashboard.</p>
                    </div>
                </div>
                <div class="text-white text-right text-sm md:text-base font-medium">
                    <p>{{ \Carbon\Carbon::now()->format('l, d M Y') }}</p>
                    <p id="current-time" class="text-lg font-bold mt-1">{{ \Carbon\Carbon::now()->format('H:i:s') }}</p>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow p-6 hover:shadow-xl transition relative overflow-hidden">
                    <div class="absolute right-4 top-4 text-4xl text-blue-100 opacity-30">🛒</div>
                    <h4 class="text-lg font-semibold text-gray-700">Total Orders</h4>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Order::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 hover:shadow-xl transition relative overflow-hidden">
                    <div class="absolute right-4 top-4 text-4xl text-green-100 opacity-30">🐠</div>
                    <h4 class="text-lg font-semibold text-gray-700">Total Products</h4>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Product::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 hover:shadow-xl transition relative overflow-hidden">
                    <div class="absolute right-4 top-4 text-4xl text-purple-100 opacity-30">👤</div>
                    <h4 class="text-lg font-semibold text-gray-700">Total Users</h4>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 hover:shadow-xl transition relative overflow-hidden">
                    <div class="absolute right-4 top-4 text-4xl text-yellow-100 opacity-30">💰</div>
                    <h4 class="text-lg font-semibold text-gray-700">Pendapatan Hari Ini</h4>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        Rp {{ number_format(\App\Models\Order::whereDate('created_at', now())->sum('total')) }}
                    </p>
                </div>
            </div>

            {{-- Management Menu --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.products') }}" class="group relative bg-green-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-green-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">🐟</div>
                    <span class="font-semibold text-lg">Manage Products</span>
                </a>

                <a href="{{ route('admin.categories') }}" class="group relative bg-yellow-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-yellow-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">📦</div>
                    <span class="font-semibold text-lg">Manage Categories</span>
                </a>

                <a href="{{ route('admin.brands') }}" class="group relative bg-orange-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-orange-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">🏷️</div>
                    <span class="font-semibold text-lg">Manage Brands</span>
                </a>

                <a href="{{ route('admin.vendors') }}" class="group relative bg-purple-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-purple-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">🏢</div>
                    <span class="font-semibold text-lg">Manage Vendors</span>
                </a>

                <a href="{{ route('admin.payment-methods') }}" class="group relative bg-blue-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-blue-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">💳</div>
                    <span class="font-semibold text-lg">Payment Methods</span>
                </a>

                <a href="{{ route('admin.shipping-methods') }}" class="group relative bg-teal-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-teal-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">🚚</div>
                    <span class="font-semibold text-lg">Shipping Methods</span>
                </a>

                <a href="{{ route('admin.orders') }}" class="group relative bg-indigo-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-indigo-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">🧾</div>
                    <span class="font-semibold text-lg">Manage Orders</span>
                </a>

                <a href="{{ route('admin.order-returns') }}" class="group relative bg-orange-900 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-gray-800 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">↩️</div>
                    <span class="font-semibold text-lg">Manage Retur</span>
                </a>

                <a href="{{ route('admin.reviews') }}" class="group relative bg-pink-500 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-pink-600 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">⭐</div>
                    <span class="font-semibold text-lg">Review Management</span>
                </a>

                <a href="{{ route('admin.reports') }}" class="group relative bg-gray-700 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-gray-800 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">📊</div>
                    <span class="font-semibold text-lg">Sales & Reports</span>
                </a>

                <a href="{{ route('admin.trash') }}" class="group relative bg-gray-900 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-gray-800 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">🗑️</div>
                    <span class="font-semibold text-lg">TrashBin</span>
                </a>

                <a href="{{ route('admin.users') }}" class="group relative bg-orange-900 rounded-xl p-6 flex flex-col items-center justify-center text-white hover:bg-gray-800 transition shadow hover:shadow-lg">
                    <div class="text-4xl mb-3 transition-transform group-hover:scale-110">👥</div>
                    <span class="font-semibold text-lg">Manage Users</span>
                </a>
            </div>

        </div>
    </div>

    {{-- Live Clock Script --}}
    <script>
        const timeElement = document.getElementById('current-time');
        setInterval(() => {
            const now = new Date();
            timeElement.textContent = now.toLocaleTimeString('id-ID', { hour12: false });
        }, 1000);
    </script>
</x-app-layout>
