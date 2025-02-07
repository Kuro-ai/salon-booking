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
