<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Review;
use App\Models\ReturnRequest;

class CustomerOrders extends Component
{
    use WithFileUploads, WithPagination;

    public $searchStatus = '';
    public $selectedOrder;
    public $deliveryProof; 
    public $rating = [];
    public $comment = [];
    public $returnReason = [];
    public $returnProof = [];

    public function updatedSearchStatus()
    {
        $this->resetPage();
    }

    public function selectOrder($orderId)
    {
        $this->selectedOrder = Order::with(['orderItems.product', 'returns', 'shippingMethod', 'user'])->findOrFail($orderId);
        $this->resetInputs();
    }

    public function closeModal()
    {
        $this->selectedOrder = null;
        $this->resetInputs();
    }

    private function resetInputs()
    {
        $this->rating = [];
        $this->comment = [];
        $this->returnReason = [];
        $this->returnProof = [];
        $this->deliveryProof = null;
    }

    public function submitReview($orderItemId)
    {
        $item = $this->selectedOrder->orderItems->firstWhere('id', $orderItemId);
        
        if (!$item) {
            session()->flash('toast', 'Produk tidak ditemukan.');
            return;
        }

        Review::updateOrCreate(
            [
                'product_id' => $item->product->id,
                'user_id' => auth()->id()
            ],
            [
                'rating' => $this->rating[$orderItemId] ?? null,
                'comment' => $this->comment[$orderItemId] ?? null
            ]
        );

        $this->rating[$orderItemId] = null;
        $this->comment[$orderItemId] = null;
        session()->flash('toast', 'Review berhasil dikirim.');
    }

    public function submitReturn($orderItemId)
    {
        $item = $this->selectedOrder->orderItems->firstWhere('id', $orderItemId);
        
        if (!$item) {
            session()->flash('toast', 'Produk tidak ditemukan.');
            return;
        }

        if (empty($this->returnReason[$orderItemId])) {
            session()->flash('toast', 'Alasan retur tidak boleh kosong.');
            return;
        }

        $path = isset($this->returnProof[$orderItemId]) 
            ? $this->returnProof[$orderItemId]->store('return-proofs', 'public') 
            : null;

        ReturnRequest::create([
            'order_id' => $this->selectedOrder->id,
            'order_item_id' => $item->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'reason' => $this->returnReason[$orderItemId],
            'item_proof' => $path,
        ]);

        $this->returnReason[$orderItemId] = null;
        $this->returnProof[$orderItemId] = null;
        session()->flash('toast', 'Permintaan retur berhasil dikirim.');
    }

    public function markAsReceived()
    {
        $this->validate([
            'deliveryProof' => 'required|image|max:2048',
        ]);

        if ($this->selectedOrder && $this->selectedOrder->status === 'dikirim') {
            $path = $this->deliveryProof->store('delivery-proofs', 'public');

            $this->selectedOrder->update([
                'status' => 'completed',
                'delivery_proof' => $path
            ]);

            $this->selectedOrder = $this->selectedOrder->fresh(['orderItems.product', 'returns', 'shippingMethod', 'user']);
            $this->deliveryProof = null;
            session()->flash('toast', 'Pesanan berhasil diterima.');
        }
    }

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->when($this->searchStatus, fn($q) => $q->where('status', $this->searchStatus))
            ->with(['orderItems.product', 'returns', 'shippingMethod', 'user'])
            ->latest()
            ->paginate(9);

        return view('livewire.customer.customer-orders', [
            'orders' => $orders
        ])->layout('layouts.app');
    }
}