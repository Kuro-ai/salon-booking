<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('admin.category-management', \App\Livewire\Admin\CategoryManagement::class);
        Livewire::component('admin.product-management', \App\Livewire\Admin\ProductManagement::class);
        Livewire::component('admin.orders', \App\Livewire\Admin\Orders::class);
        Livewire::component('admin.users', \App\Livewire\Admin\Users::class);
        Livewire::component('admin.dashboard', \App\Livewire\Admin\Dashboard::class);

        Livewire::component('customer.homepage', \App\Livewire\Customer\Homepage::class);
        Livewire::component('customer.product-details', \App\Livewire\Customer\ProductDetails::class);
        Livewire::component('customer.shopping-cart', \App\Livewire\Customer\ShoppingCart::class);
    }
}
