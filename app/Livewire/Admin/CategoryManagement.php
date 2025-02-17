<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryManagement extends Component
{
    public $categories;
    public $newCategory = '';

    public $editingId = null;
    public $editName = '';

    public $confirmingDelete = null;

    public $search = '';

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function addCategory()
    {
        if (!empty(trim($this->newCategory))) {
            Category::create([
                'name' => $this->newCategory,
                'slug' => Str::slug($this->newCategory),
            ]);

            session()->flash('message', 'Category added successfully!'); // Flash message

            $this->newCategory = ''; // Reset input field
            $this->loadCategories();
        }
    }

    public function editCategory($id, $name)
    {
        $this->editingId = $id;
        $this->editName = $name;
    }

    public function saveEdit($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->name = $this->editName;
            $category->slug = Str::slug($this->editName);
            $category->save();

            session()->flash('message', 'Category updated successfully!'); // Flash message
        }

        $this->cancelEdit();
        $this->loadCategories();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editName = '';
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteCategory($id)
    {
        Category::find($id)?->delete();
        session()->flash('message', 'Category deleted successfully!'); // Flash message

        $this->confirmingDelete = null;
        $this->loadCategories();
    }

    public function render()
    {
        $this->loadCategories();
        return view('livewire.admin.category-management');
    }

}
