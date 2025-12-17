<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vendor;

class VendorManagement extends Component
{
    use WithPagination;

    public $name, $address, $phone, $vendorId;
    public $search = '';
    public $updateMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:50',
    ];

    public function layout()
    {
        return 'layouts.app';
    }

    public function render()
    {
        $vendors = Vendor::withoutTrashed()  
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.vendor-management', [
            'vendors' => $vendors
        ])->layout('layouts.app');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->address = '';
        $this->phone = '';
        $this->vendorId = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate();

        Vendor::create([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
        ]);

        session()->flash('message', 'Vendor berhasil ditambahkan.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);

        $this->vendorId = $id;
        $this->name = $vendor->name;
        $this->address = $vendor->address;
        $this->phone = $vendor->phone;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->vendorId) {
            $vendor = Vendor::find($this->vendorId);

            $vendor->update([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
            ]);

            session()->flash('message', 'Vendor berhasil diperbarui.');
            $this->resetInput();
        }
    }

    public function delete($id)
    {
        Vendor::find($id)->delete();

        session()->flash('message', 'Vendor berhasil dihapus dan dipindahkan ke Trash Bin.');
    }
}
