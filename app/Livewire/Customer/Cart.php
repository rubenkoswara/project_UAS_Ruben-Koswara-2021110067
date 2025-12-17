<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class Cart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function increment($productId)
    {
        if(isset($this->cart[$productId])){
            $this->cart[$productId]['quantity']++;
            session()->put('cart', $this->cart);
        }
    }

    public function decrement($productId)
    {
        if(isset($this->cart[$productId]) && $this->cart[$productId]['quantity'] > 1){
            $this->cart[$productId]['quantity']--;
            session()->put('cart', $this->cart);
        }
    }

    public function remove($productId)
    {
        if(isset($this->cart[$productId])){
            unset($this->cart[$productId]);
            session()->put('cart', $this->cart);
        }
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(function($item){
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.customer.cart')->layout('layouts.app');
    }
}
