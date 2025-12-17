<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ShippingMethod;

class ShippingMethodManagement extends Component
{
    use WithPagination;

    public $name, $cost, $shippingId;
    public $search = '';
    public $updateMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'cost' => 'required|numeric',
    ];
    
    public function render()
    {
        $methods = ShippingMethod::where('name','like','%'.$this->search.'%')
                    ->orWhere('cost','like','%'.$this->search.'%')
                    ->latest()
                    ->paginate(10);
        return view('livewire.admin.shipping-method-management', ['methods' => $methods])->layout('layouts.app');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->cost = '';
        $this->shippingId = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate();
        ShippingMethod::create([
            'name' => $this->name,
            'cost' => $this->cost,
        ]);
        session()->flash('message', 'Jasa kirim berhasil ditambahkan.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $method = ShippingMethod::findOrFail($id);
        $this->shippingId = $id;
        $this->name = $method->name;
        $this->cost = $method->cost;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();
        if($this->shippingId){
            $method = ShippingMethod::find($this->shippingId);
            $method->update([
                'name' => $this->name,
                'cost' => $this->cost,
            ]);
            session()->flash('message','Jasa kirim berhasil diperbarui.');
            $this->resetInput();
        }
    }

    public function delete($id)
    {
        ShippingMethod::find($id)->delete();
        session()->flash('message','Jasa kirim berhasil dihapus.');
    }

    public function restore($id)
    {
        ShippingMethod::withTrashed()->find($id)->restore();
        session()->flash('message','Jasa kirim berhasil dipulihkan.');
    }
}
