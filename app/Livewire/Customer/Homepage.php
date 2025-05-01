<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Advertisement;
class Homepage extends Component
{
    use WithPagination;

    public $search = '';
    public $minPrice = 1;
    public $maxPrice = 100;
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

        $categories = Category::with(['products' => function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);

            if (
                is_numeric($this->minPrice) && is_numeric($this->maxPrice) &&
                $this->minPrice !== '' && $this->maxPrice !== ''
            ) {
                $query->whereBetween('price', [$this->minPrice, $this->maxPrice]);
            }

            if ($this->categoryFilter) {
                $query->where('category_id', $this->categoryFilter);
            }
        }])->get();

        $bestSellingProducts = $this->getBestSellingProducts();

        return view('livewire.customer.homepage', [
            'categories' => $categories,
            'ads' => $ads,
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }
    
    private function getBestSellingProducts()
    {
        return Product::select('products.id', 'products.name', 'products.image', 'products.price', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('products.id', 'products.name', 'products.image', 'products.price')
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();
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
