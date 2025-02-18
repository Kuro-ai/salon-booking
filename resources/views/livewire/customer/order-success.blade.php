<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="container mx-auto p-8 text-center max-w-lg bg-white shadow-lg rounded-2xl">
        <h2 class="text-4xl font-extrabold text-green-600">🎉 Thank You!</h2>
        <p class="text-lg mt-3 text-gray-700">
            Your order <span class="font-semibold text-gray-900">(#{{ $order->id }})</span> has been placed successfully.
        </p>
        
        <a href="{{ route('customer.dashboard') }}" 
           class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition duration-300 shadow-md">
            Continue Shopping
        </a>
    </div>
</div>

