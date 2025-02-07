<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryManagement extends Component
{
    public $categories;
    public $newCategory = '';

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::orderBy('id', 'desc')->get();
    }

    public function addCategory()
    {
        if (!empty(trim($this->newCategory))) {
            Category::create([
                'name' => $this->newCategory,
                'slug' => Str::slug($this->newCategory),
            ]);

            $this->newCategory = ''; // Reset input field
            $this->loadCategories();
        }
    }

    public function updateCategory($id, $field, $value)
    {
        $category = Category::find($id);
        if ($category) {
            $category->$field = $value;
            if ($field == 'name') {
                $category->slug = Str::slug($value);
            }
            $category->save();
            $this->loadCategories();
        }
    }

    public function deleteCategory($id)
    {
        Category::find($id)?->delete();
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.admin.category-management');
    }
}
