<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Coupon;
use Carbon\Carbon;

class ShoppingCart extends Component
{
    public $cart = [];
    public $couponCode;
    public $discount = 0;
    public $discountType;
    public $minimumOrderAmount;
    public $appliedCoupon = null;

    public function mount()
    {
        $this->cart = Session::get('cart', []);
        $this->appliedCoupon = Session::get('applied_coupon', null);
        if ($this->appliedCoupon) {
            $this->applyDiscount($this->appliedCoupon);
        }
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $this->cart);
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity > 0) {
            $this->cart[$productId]['quantity'] = $quantity;
        } else {
            unset($this->cart[$productId]);
        }

        Session::put('cart', $this->cart);
        $this->refreshDiscount();
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        Session::put('cart', $this->cart);
        $this->refreshDiscount();

        // Emit event to refresh the component
        $this->dispatch('cartUpdated');
    }


    public function refreshDiscount()
    {
        if ($this->appliedCoupon) {
            $this->applyDiscount($this->appliedCoupon); 
        } else {
            $this->discount = 0;
        }
        Session::put('discount', $this->calculateDiscountAmount());
    }

    public function clearCart()
    {
        $this->cart = [];
        Session::forget('cart');
        Session::forget('applied_coupon');
        $this->resetCoupon();
        $this->dispatch('cartUpdated');
    }

    public function getTotalPrice()
    {
        return array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $this->cart));
    }

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', strtoupper($this->couponCode))
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', Carbon::now());
            })
            ->first();

        if (!$coupon) {
            session()->flash('error', 'Invalid or expired coupon.');
            return;
        }

        if ($coupon->minimum_order_amount && $this->getTotalPrice() < $coupon->minimum_order_amount) {
            session()->flash('error', 'Minimum order amount not met.');
            return;
        }

        $this->applyDiscount($coupon);
        Session::put('applied_coupon', $coupon);
        session()->flash('message', 'Coupon applied successfully!');
    }

    public function applyDiscount($coupon)
    {
        $this->discount = $coupon->discount_value;
        $this->discountType = $coupon->discount_type;
        $this->minimumOrderAmount = $coupon->minimum_order_amount;
        $this->appliedCoupon = $coupon;

        Session::put('discount', $this->calculateDiscountAmount());
        Session::put('applied_coupon', $coupon);
    }

    private function calculateDiscountAmount()
    {
        $total = $this->getTotalPrice();
        if ($this->discountType === 'percentage') {
            return $total * ($this->discount / 100);
        } elseif ($this->discountType === 'fixed') {
            return $this->discount;
        }
        return 0;
    }

    public function getFinalTotal()
    {
        $total = $this->getTotalPrice();
        if ($this->discountType === 'percentage') {
            return max(0, $total - ($total * ($this->discount / 100)));
        } elseif ($this->discountType === 'fixed') {
            return max(0, $total - $this->discount);
        }
        return $total;
    }

    public function removeCoupon()
    {
        Session::forget('applied_coupon');
        $this->resetCoupon();
    }

    private function resetCoupon()
    {
        $this->discount = 0;
        $this->discountType = null;
        $this->minimumOrderAmount = null;
        $this->appliedCoupon = null;
    }

    public function render()
    {
        return view('livewire.customer.shopping-cart');
    }
}


