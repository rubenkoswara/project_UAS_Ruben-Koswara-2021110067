<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PaymentMethod;
use Livewire\WithPagination;

class PaymentMethodManagement extends Component
{
    use WithPagination;

    public $name, $bank_name, $account_number, $account_name, $paymentId;
    public $search = '';
    public $updateMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'bank_name' => 'required|string|max:255',
        'account_number' => 'required|string|max:50',
        'account_name' => 'required|string|max:255',
    ];

    public function render()
    {
        $methods = PaymentMethod::where('name','like','%'.$this->search.'%')
                    ->orWhere('bank_name','like','%'.$this->search.'%')
                    ->latest()
                    ->paginate(10);
        return view('livewire.admin.payment-method-management', ['methods' => $methods])->layout('layouts.app');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->bank_name = '';
        $this->account_number = '';
        $this->account_name = '';
        $this->paymentId = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate();
        PaymentMethod::create([
            'name' => $this->name,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
        ]);
        session()->flash('message', 'Metode pembayaran berhasil ditambahkan.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $this->paymentId = $id;
        $this->name = $method->name;
        $this->bank_name = $method->bank_name;
        $this->account_number = $method->account_number;
        $this->account_name = $method->account_name;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();
        if($this->paymentId){
            $method = PaymentMethod::find($this->paymentId);
            $method->update([
                'name' => $this->name,
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'account_name' => $this->account_name,
            ]);
            session()->flash('message','Metode pembayaran berhasil diperbarui.');
            $this->resetInput();
        }
    }

    public function delete($id)
    {
        PaymentMethod::find($id)->delete();
        session()->flash('message','Metode pembayaran berhasil dihapus.');
    }

    public function restore($id)
    {
        PaymentMethod::withTrashed()->find($id)->restore();
        session()->flash('message','Metode pembayaran berhasil dipulihkan.');
    }
}
