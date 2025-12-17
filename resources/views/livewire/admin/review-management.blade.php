<div class="p-6 bg-gray-100 min-h-screen">
    <h2 class="text-3xl font-bold text-gray-700 mb-6">Manajemen Review & Rating</h2>

    @if(session()->has('message'))
        <div class="p-3 mb-4 bg-green-100 border border-green-300 text-green-700 rounded-md shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white border rounded-xl shadow-sm p-5 mb-6">
        <div class="flex flex-wrap gap-4">

            <input type="text"
                   wire:model="searchProduct"
                   placeholder="Cari produk..."
                   class="border border-gray-300 p-2 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">

            <select wire:model="searchRating"
                    class="border border-gray-300 p-2 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">Semua Rating</option>
                <option value="1">1 Bintang</option>
                <option value="2">2 Bintang</option>
                <option value="3">3 Bintang</option>
                <option value="4">4 Bintang</option>
                <option value="5">5 Bintang</option>
            </select>

        </div>
    </div>

    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 text-gray-700">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-sm">ID</th>
                    <th class="px-4 py-3 text-left font-semibold text-sm">Produk</th>
                    <th class="px-4 py-3 text-left font-semibold text-sm">Customer</th>
                    <th class="px-4 py-3 text-left font-semibold text-sm">Rating</th>
                    <th class="px-4 py-3 text-left font-semibold text-sm">Komentar</th>
                    <th class="px-4 py-3 text-left font-semibold text-sm">Tanggal</th>
                    <th class="px-4 py-3 text-center font-semibold text-sm">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($reviews as $review)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">{{ $review->id }}</td>

                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $review->product->name }}
                    </td>

                    <td class="px-4 py-3">{{ $review->user->name }}</td>

                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 font-semibold rounded-lg">
                            ⭐ {{ $review->rating }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ Str::limit($review->comment, 40) }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $review->created_at->format('d/m/Y') }}
                    </td>

                    <td class="px-4 py-3 flex justify-center gap-2">

                        <button wire:click="selectReview({{ $review->id }})"
                            class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm transition">
                            Detail
                        </button>

                        <button wire:click="deleteReview({{ $review->id }})"
                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm transition">
                            Hapus
                        </button>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 bg-gray-50 border-t">
            {{ $reviews->links() }}
        </div>
    </div>

    @if($selectedReview)
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

        <div class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 border animate-[fadeIn_0.2s_ease]">

            <h3 class="text-xl font-bold text-gray-800 mb-4">
                Detail Review #{{ $selectedReview->id }}
            </h3>

            <div class="space-y-3 text-gray-700">

                <p><strong>Produk:</strong> {{ $selectedReview->product->name }}</p>
                <p><strong>Customer:</strong> {{ $selectedReview->user->name }}</p>

                <p>
                    <strong>Rating:</strong>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded font-semibold">
                        ⭐ {{ $selectedReview->rating }}
                    </span>
                </p>

                <p><strong>Komentar:</strong> {{ $selectedReview->comment }}</p>

                <p>
                    <strong>Tanggal:</strong>
                    {{ $selectedReview->created_at->format('d/m/Y H:i') }}
                </p>

            </div>

            <div class="flex justify-end mt-6">
                <button wire:click="$set('selectedReview', null)"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-sm">
                    Tutup
                </button>
            </div>

        </div>

    </div>
    @endif

</div>
