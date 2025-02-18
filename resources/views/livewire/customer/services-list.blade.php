<div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto mt-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Available Services</h2>
    
    <ul class="space-y-4">
        @foreach ($services as $service)
            <li class="flex justify-between items-center p-4 border-b border-gray-200 hover:bg-gray-50 transition duration-300">
                <a href="{{ route('service.book', $service->id) }}" 
                   class="text-blue-600 hover:text-blue-800 text-lg font-medium transition duration-200">
                    {{ $service->name }}
                </a>
                <span class="text-lg font-semibold text-gray-700">${{ number_format($service->price, 2) }}</span>
            </li>
        @endforeach
    </ul>
</div>
