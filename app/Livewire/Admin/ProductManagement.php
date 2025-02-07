<?php 

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ProductManagement extends Component
{
    use WithFileUploads;

    public $products, $categories;
    public $newProduct = [
        'name' => '',
        'description' => '',
        'price' => '',
        'stock' => '',
        'category_id' => '',
        'image' => null
    ];

    public function mount()
    {
        $this->loadProducts();
        $this->categories = Category::orderBy('name')->get();
    }

    public function loadProducts()
    {
        $this->products = Product::orderBy('id', 'desc')->get();
    }

    public function addProduct()
    {
        $validatedData = $this->validate([
            'newProduct.name' => 'required|string',
            'newProduct.description' => 'nullable|string',
            'newProduct.price' => 'required|numeric|min:0',
            'newProduct.stock' => 'required|integer|min:0',
            'newProduct.category_id' => 'required|exists:categories,id',
            'newProduct.image' => 'nullable|image|max:1024',
        ]);

        // Handle image upload
        if ($this->newProduct['image']) {
            $imagePath = $this->newProduct['image']->store('products', 'public');
            $validatedData['newProduct']['image'] = $imagePath;
        }

        Product::create([
            'name' => $validatedData['newProduct']['name'],
            'slug' => Str::slug($validatedData['newProduct']['name']),
            'description' => $validatedData['newProduct']['description'],
            'price' => $validatedData['newProduct']['price'],
            'stock' => $validatedData['newProduct']['stock'],
            'category_id' => $validatedData['newProduct']['category_id'],
            'image' => $validatedData['newProduct']['image'] ?? null
        ]);

        // Reset input fields
        $this->newProduct = ['name' => '', 'description' => '', 'price' => '', 'stock' => '', 'category_id' => '', 'image' => null];
        $this->loadProducts();
    }

    public function updateProduct($id, $field, $value)
    {
        $product = Product::find($id);
        if ($product) {
            $product->$field = $value;
            if ($field == 'name') {
                $product->slug = Str::slug($value);
            }
            $product->save();
            $this->loadProducts();
        }
    }

    public function deleteProduct($id)
    {
        Product::find($id)?->delete();
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.admin.product-management');
    }
}
