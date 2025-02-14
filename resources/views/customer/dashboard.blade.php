<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <nav class="bg-gray-800 text-white p-4">
        <ul class="flex space-x-4">
            <li><a href="/" class="hover:underline">Home</a></li>
            <li><a href="/order-history" class="hover:underline">Order History</a></li>
            <li><a href="/order-tracking" class="hover:underline">Track Order</a></li>
            <a href="{{ route('wishlist') }}" class="text-white px-4 py-2 bg-pink-500">Wishlist</a>
            <div class="flex items-center space-x-4">
                @livewire('customer.mini-cart')
            </div>
            <a href="{{ route('service.list') }}" class="text-white px-4 py-2 bg-pink-500">Service List</a>
        </ul>
    </nav>
    
    @livewire('customer.homepage')
</x-app-layout>
