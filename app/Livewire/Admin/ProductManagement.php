<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductManagement extends Component
{
    use WithFileUploads, WithPagination;

    public $newProductName = '';
    public $newProductDescription = '';
    public $newProductPrice = '';
    public $newProductStock = '';
    public $newProductCategoryId = '';
    public $newProductImage = null;

    public $editingId = null, $editName, $editDescription, $editPrice, $editStock, $editCategory, $editImage, $editImagePreview;
    public $confirmingDelete = null;
    public $search = '', $categoryFilter = '';

    protected $rules = [
        'newProductName' => 'required|string',
        'newProductDescription' => 'nullable|string',
        'newProductPrice' => 'required|numeric|min:0',
        'newProductStock' => 'required|integer|min:0',
        'newProductCategoryId' => 'required|exists:categories,id',
        'newProductImage' => 'nullable|image',
    ];

    public function updatedSearch()
    {
        $this->resetPage(); 
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage(); 
    }

    public function addProduct()
    {
        $this->validate();

        $imagePath = $this->newProductImage ? $this->newProductImage->store('products', 'public') : null;

        Product::create([
            'name' => $this->newProductName,
            'slug' => Str::slug($this->newProductName),
            'description' => $this->newProductDescription,
            'price' => $this->newProductPrice,
            'stock' => $this->newProductStock,
            'category_id' => $this->newProductCategoryId,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Product added successfully!');

        // Reset input fields
        $this->reset([
            'newProductName', 'newProductDescription', 'newProductPrice', 
            'newProductStock', 'newProductCategoryId', 'newProductImage'
        ]);
    }


    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->editingId = $id;
        $this->editName = $product->name;
        $this->editDescription = $product->description;
        $this->editPrice = $product->price;
        $this->editStock = $product->stock;
        $this->editCategory = $product->category_id;
        $this->editImage = null;
        $this->editImagePreview = $product->image ? asset('storage/' . $product->image) : null;
    }

    public function updatedEditImage()
    {
        if ($this->editImage) {
            $this->editImagePreview = $this->editImage->temporaryUrl();
        }
    }

    public function saveEdit()
    {
        $product = Product::find($this->editingId);

        if ($product) {
            $updateData = [
                'name' => $this->editName,
                'slug' => Str::slug($this->editName),
                'description' => $this->editDescription,
                'price' => $this->editPrice,
                'stock' => $this->editStock,
                'category_id' => $this->editCategory,
            ];

            if ($this->editImage) {
                $imagePath = $this->editImage->store('products', 'public');
                $updateData['image'] = $imagePath;
            }

            $product->update($updateData);
            session()->flash('message', 'Product updated successfully!');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteProduct($id)
    {
        Product::destroy($id);
        session()->flash('message', 'Product deleted successfully!');
        $this->confirmingDelete = null;
    }

    public function render()
    {
        $products = Product::orderBy('id', 'desc')
            ->where('name', 'like', '%' . strtolower($this->search) . '%')
            ->when($this->categoryFilter, function ($query) {
                return $query->where('category_id', $this->categoryFilter);
            })
            ->paginate(10);

        return view('livewire.admin.product-management', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
