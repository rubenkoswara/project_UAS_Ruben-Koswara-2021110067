<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Vendor;

class ProductCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $description;
    public $category_id, $brand_id, $vendor_id;
    public $price, $stock;
    public $image, $oldImage;

    public $filterCategory = '';
    public $filterBrand = '';
    public $filterVendor = '';

    public $showModal = false;
    public $isEdit = false;
    public $editId;

    public $showImageModal = false;
    public $selectedImageUrl = '';

    protected $rules = [
        'name'        => 'required',
        'category_id' => 'required',
        'brand_id'    => 'required',
        'vendor_id'   => 'required',
        'price'       => 'required|numeric',
        'stock'       => 'required|numeric',
    ];

    public function render()
    {
        $query = Product::query();

        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }
        if ($this->filterBrand) {
            $query->where('brand_id', $this->filterBrand);
        }
        if ($this->filterVendor) {
            $query->where('vendor_id', $this->filterVendor);
        }

        return view('livewire.admin.product-crud', [
            'products'   => $query->paginate(10),
            'categories' => Category::all(),
            'brands'     => Brand::all(),
            'vendors'    => Vendor::all(),
        ])->layout('layouts.app');
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->isEdit = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    private function resetForm()
    {
        $this->reset([
            'name','description','category_id','brand_id','vendor_id',
            'price','stock','image','oldImage'
        ]);
    }

    public function store()
    {
        $this->validate();

        $filename = null;
        if ($this->image) {
            $filename = $this->image->store('products', 'public');
        }

        Product::create([
            'name'        => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'brand_id'    => $this->brand_id,
            'vendor_id'   => $this->vendor_id,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'image'       => $filename,
        ]);

        session()->flash('message', 'Produk berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $this->isEdit = true;
        $this->editId = $id;
        $this->showModal = true;

        $data = Product::find($id);

        $this->name        = $data->name;
        $this->description = $data->description;
        $this->category_id = $data->category_id;
        $this->brand_id    = $data->brand_id;
        $this->vendor_id   = $data->vendor_id;
        $this->price       = $data->price;
        $this->stock       = $data->stock;
        $this->oldImage    = $data->image;
    }

    public function update()
    {
        $this->validate();

        $product = Product::find($this->editId);

        $filename = $product->image;

        if ($this->image) {
            $filename = $this->image->store('products', 'public');
        }

        $product->update([
            'name'        => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'brand_id'    => $this->brand_id,
            'vendor_id'   => $this->vendor_id,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'image'       => $filename,
        ]);

        session()->flash('message', 'Produk berhasil diperbarui.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Produk berhasil dihapus.');
    }

    public function openImageModal($imageUrl)
    {
        $this->selectedImageUrl = $imageUrl;
        $this->showImageModal = true;
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->selectedImageUrl = '';
    }
}
