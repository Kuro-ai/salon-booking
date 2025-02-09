<div class="container mx-auto p-6 text-center">
    <h2 class="text-3xl font-bold text-green-500">Thank You!</h2>
    <p class="text-lg mt-2">Your order (#{{ $order->id }}) has been placed successfully.</p>
    <p class="mt-4">You will receive a confirmation email shortly.</p>
    <a href="{{ route('customer.dashboard') }}" class="mt-6 bg-blue-500 text-white px-6 py-2 inline-block">Continue Shopping</a>
</div>
