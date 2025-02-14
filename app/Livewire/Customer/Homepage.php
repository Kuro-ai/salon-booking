<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Advertisement;
class Homepage extends Component
{
    use WithPagination;

    public $search = '';
    public $minPrice = 0;
    public $maxPrice = 10000;
    public $categoryFilter = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function render()
    {
        $ads = Advertisement::all();
    
        return view('livewire.customer.homepage', [
            'categories' => Category::all(),
            'products' => Product::where('name', 'like', "%{$this->search}%")
                ->when($this->categoryFilter, fn($query) => $query->where('category_id', $this->categoryFilter))
                ->whereBetween('price', [$this->minPrice, $this->maxPrice])
                ->paginate(8),
            'ads' => $ads,
        ]);
    }
    
    public function addToCart($productId)
{
    $product = Product::find($productId);

    if (!$product) {
        session()->flash('error', 'Product not found.');
        return;
    }

    $cart = Session::get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity']++;
    } else {
        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => 1,
        ];
    }

    Session::put('cart', $cart);

    // 🔄 Notify the Mini Cart component to update
    $this->dispatch('cartUpdated');

    session()->flash('success', "{$product->name} added to cart!");
}




}
