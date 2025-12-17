<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class Catalog extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['addToCart' => 'addToCartItem'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function addToCartItem($productId)
    {
        $cart = new \App\Livewire\Customer\Cart;
        $cart->addToCart($productId);
    }

    public function render()
    {
        $categories = Category::all();

        $products = Product::with('category','brand','reviews')
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where('name','like','%'.$this->search.'%'))
            ->paginate(12);

        return view('livewire.customer.catalog', compact('products','categories'))->layout('layouts.app');
    }
}
