<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

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

    public function addToCart($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $this->product->name,
                'price' => $this->product->price,
                'image' => $this->product->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart'); // Redirect to shopping cart
    }

    public function render()
    {
        $categories = Category::all();

        $products = Product::where('name', 'like', "%{$this->search}%")
            ->when($this->categoryFilter, fn($query) => $query->where('category_id', $this->categoryFilter))
            ->whereBetween('price', [$this->minPrice, $this->maxPrice])
            ->paginate(8);

        return view('livewire.customer.homepage', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
