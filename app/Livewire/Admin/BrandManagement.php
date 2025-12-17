<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand;

class BrandManagement extends Component
{
    use WithPagination;

    public $name, $brandId, $search = '';
    public $updateMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Hanya data yang TIDAK terhapus
        $brands = Brand::whereNull('deleted_at')
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.brand-management', [
            'brands' => $brands
        ])->layout('layouts.app');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->brandId = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate();
        Brand::create([
            'name' => $this->name,
        ]);
        session()->flash('message', 'Brand berhasil ditambahkan.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brandId = $id;
        $this->name = $brand->name;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->brandId) {
            $brand = Brand::find($this->brandId);
            $brand->update([
                'name' => $this->name,
            ]);

            session()->flash('message', 'Brand berhasil diperbarui.');
            $this->resetInput();
        }
    }

    public function delete($id)
    {
        Brand::find($id)->delete();

        session()->flash('message', 'Brand berhasil dipindahkan ke Trash Bin.');
    }
}
