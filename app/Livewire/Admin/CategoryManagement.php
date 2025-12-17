<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryManagement extends Component
{
    use WithPagination;

    public $name, $description, $categoryId;
    public $search = '';
    public $updateMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $categories = Category::whereNull('deleted_at') 
            ->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('description','like','%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.category-management', compact('categories'))
            ->layout('layouts.app');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->description = '';
        $this->categoryId = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Kategori berhasil ditambahkan.');
        $this->resetInput();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->categoryId) {
            $category = Category::find($this->categoryId);

            if ($category) {
                $category->update([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
            }

            session()->flash('message','Kategori berhasil diperbarui.');
            $this->resetInput();
        }
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete(); // soft delete
            session()->flash('message','Kategori dipindahkan ke Trash Bin.');
        }
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category) {
            $category->restore();
            session()->flash('message','Kategori berhasil dipulihkan.');
        }
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category) {
            $category->forceDelete();
            session()->flash('message','Kategori dihapus permanen.');
        }
    }
}
