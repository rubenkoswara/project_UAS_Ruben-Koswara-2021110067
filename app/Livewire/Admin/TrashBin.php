<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

// Import semua model
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Models\Review;
use App\Models\ShippingMethod;
use App\Models\Vendor;

class TrashBin extends Component
{
    use WithPagination;

    public $model = null;
    public $search = '';

    public $models = [
        'Brand'            => Brand::class,
        'Category'         => Category::class,
        'Order'            => Order::class,
        'Order Item'       => OrderItem::class,
        'Payment Method'   => PaymentMethod::class,
        'Product'          => Product::class,
        'Return Request'   => ReturnRequest::class,
        'Review'           => Review::class,
        'Shipping Method'  => ShippingMethod::class,
        'Vendor'           => Vendor::class,
    ];

    public function mount()
    {
        // default model
        $this->model = Brand::class;
    }

    public function updatedModel()
    {
        $this->resetPage();
    }

    public function render()
    {
        $model = $this->model;

        $trashData = $model::onlyTrashed()
            ->when($this->search, fn($q) =>
                $q->where('name','like','%'.$this->search.'%')
                  ->orWhere('id','like','%'.$this->search.'%')
            )
            ->paginate(10);

        return view('livewire.admin.trash-bin', [
            'trashData'      => $trashData,
            'models'         => $this->models,
            'selectedModel'  => array_search($this->model, $this->models),
        ])->layout('layouts.app');
    }

    public function restore($id)
    {
        $this->model::withTrashed()->find($id)?->restore();
        session()->flash('message', 'Data berhasil dipulihkan.');
    }

    public function deletePermanent($id)
    {
        $this->model::withTrashed()->find($id)?->forceDelete();
        session()->flash('message', 'Data berhasil dihapus permanen.');
    }
}
