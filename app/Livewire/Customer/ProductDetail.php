<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($id)
    {
        $this->product = Product::with('category', 'brand', 'reviews')->findOrFail($id);
    }

    public function increment()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$this->product->id])){
            $cart[$this->product->id]['quantity'] += $this->quantity;
        } else {
            $cart[$this->product->id] = [
                "name" => $this->product->name,
                "quantity" => $this->quantity,
                "price" => $this->product->price,
                "image" => $this->product->image
            ];
        }

        session()->put('cart', $cart);
        session()->flash('message', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function render()
    {
        $rating = round($this->product->reviews->avg('rating'), 1) ?? 0;
        return view('livewire.customer.product-detail', compact('rating'))->layout('layouts.app');
    }
}
