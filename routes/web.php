<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Route::get('/admin/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');

    Route::get('/admin/categories', \App\Livewire\Admin\CategoryManagement::class)->name('admin.categories');
    Route::get('/admin/products', \App\Livewire\Admin\ProductManagement::class)->name('admin.products');
    Route::get('/admin/orders', \App\Livewire\Admin\Orders::class)->name('admin.orders');
    Route::get('/admin/users', \App\Livewire\Admin\Users::class)->name('admin.users');
    Route::get('/admin/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/admin/coupons', \App\Livewire\Admin\Coupons::class)->name('admin.coupons');
    Route::get('/admin/advertisements', \App\Livewire\Admin\Advertisements::class)->name('admin.advertisements');
    Route::get('/admin/services', \App\Livewire\Admin\ManageServices::class)->name('admin.services');
    Route::get('/admin/staff', \App\Livewire\Admin\ManageStaff::class)->name('admin.staff');
    Route::get('/admin/staff-schedules', \App\Livewire\Admin\ManageStaffSchedules::class)->name('admin.staff-schedules');
});

Route::middleware(['auth', 'customer'])->group(function () {
    // Route::get('/', \App\Livewire\Customer\Homepage::class)->name('customer.homepage');
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
    Route::get('/product/{productId}', \App\Livewire\Customer\ProductDetails::class)->name('product.details');
    Route::get('/cart', \App\Livewire\Customer\ShoppingCart::class)->name('cart');
    Route::get('/checkout', \App\Livewire\Customer\Checkout::class)->name('checkout');
    Route::get('/order-success/{orderId}', \App\Livewire\Customer\OrderSuccess::class)->name('order.success');
    Route::get('/order-tracking', \App\Livewire\Customer\OrderTracking::class)->name('order.tracking');
    Route::get('/order-history', \App\Livewire\Customer\OrderHistory::class)->name('order.history');
    Route::get('/wishlist', \App\Livewire\Customer\WishlistPage::class)->name('wishlist');
    Route::get('/services', \App\Livewire\Customer\ServicesList::class)->name('service.list');
    Route::get('/service/{serviceId}/book', \App\Livewire\Customer\StaffSchedules::class)
    ->name('service.book');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'customer':
                return view('customer.dashboard');
            default:
                abort(403, 'Unauthorized access');
        }
    })->name('dashboard');
});
