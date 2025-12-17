<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Order;
use App\Models\Product;

class OrderManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $searchStatus = '';
    public $searchDate = '';
    public $selectedOrder;
    public $newStatus;
    public $resi;
    public $showDetailModal = false;

    protected $rules = [
        'newStatus' => 'required|string',
        'resi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    public function render()
    {
        $query = Order::with('user', 'orderItems.product')->latest();

        if ($this->searchStatus) {
            $query->where('status', $this->searchStatus);
        }

        if ($this->searchDate) {
            $query->whereDate('created_at', $this->searchDate);
        }

        return view('livewire.admin.order-management', [
            'orders' => $query->paginate(10)
        ])->layout('layouts.app');
    }

    public function selectOrder($orderId)
    {
        $this->selectedOrder = Order::with('orderItems.product', 'user')->findOrFail($orderId);
        $this->newStatus = $this->selectedOrder->status;
        $this->resi = null;
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->selectedOrder = null;
        $this->resi = null;
        $this->showDetailModal = false;
    }

    public function updateStatus()
    {
        $this->validate();

        if ($this->resi) {
            $path = $this->resi->store('resi', 'public');
            $this->selectedOrder->receipt = $path;
        }

        if ($this->newStatus === 'canceled' && $this->selectedOrder->status !== 'canceled') {
            foreach ($this->selectedOrder->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
        }

        $this->selectedOrder->status = $this->newStatus;
        $this->selectedOrder->save();

        session()->flash('message', 'Status pesanan berhasil diperbarui!');
        $this->closeDetailModal();
    }
}
