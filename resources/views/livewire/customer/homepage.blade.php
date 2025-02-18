<div class="container mx-auto p-6">
    <!-- Advertisement Carousel -->
    <div x-data="carousel({{ count($ads ?? []) }})" class="relative w-full overflow-hidden rounded-lg shadow-lg">
        <div class="flex transition-transform duration-500 ease-in-out" :style="'transform: translateX(-' + (currentIndex * 100) + '%)'" wire:ignore.self>
            @foreach($ads as $index => $ad)
                <div class="w-full flex-shrink-0 relative">
                    <a href="{{ $ad->link }}" class="block">
                        <div class="relative rounded-lg overflow-hidden shadow-lg">
                            <img src="{{ asset('storage/' . $ad->image) }}" class="w-full h-64 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-4">
                                <h3 class="text-white text-xl font-semibold">{{ $ad->title }}</h3>
                                <p class="text-white text-sm">{{ $ad->text }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Navigation Arrows -->
        <button @click="prevSlide" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-white bg-gray-800 bg-opacity-75 p-3 rounded-full shadow-lg hover:bg-gray-900">
            &#10094;
        </button>
        <button @click="nextSlide" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white bg-gray-800 bg-opacity-75 p-3 rounded-full shadow-lg hover:bg-gray-900">
            &#10095;
        </button>

        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach($ads as $index => $ad)
                <div class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                    :class="currentIndex === {{ $index }} ? 'bg-white scale-125' : 'bg-gray-400'"
                    @click="currentIndex = {{ $index }}"></div>
            @endforeach
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 mt-3 rounded-md shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Find Your Perfect Product</h2>
        <div class="flex space-x-4">
            <input type="text" wire:model.live="search" class="border p-3 w-1/3 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Search products...">
            
            <select wire:model.live="categoryFilter" class="border p-3 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <input type="number" min=0 wire:model.live="minPrice" class="border p-3 w-1/6 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Min Price">
            <input type="number" min=20 wire:model.live="maxPrice" class="border p-3 w-1/6 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Max Price">
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow mt-6">
        <h3 class="text-xl font-bold mb-4">Best-Selling Products</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($bestSellingProducts as $product)
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 border border-gray-200">
                    <a href="{{ route('product.details', $product->id) }}" class="block">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover rounded-lg">
                        </div>
                        <h3 class="font-semibold text-lg mt-3 text-gray-900">{{ $product->name }}</h3>
                        <p class="text-blue-600 text-lg font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                    </a>
    
                    <div class="mt-4 flex items-center justify-between">
                        <button wire:click="addToCart({{ $product->id }})"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all flex items-center justify-center w-full">
                            🛒 Add to Cart
                        </button>
                    </div>
    
                    <div class="mt-2 text-center">
                        <span class="text-gray-500 text-sm">{{ $product->total_sold }} Sold</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    
    <!-- Product Grid -->
    <div class="bg-white container mx-auto p-6">
        <!-- Loop through each category -->
        @foreach($categories as $category)
            @if($category->products->count() > 0)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
                        @foreach($category->products as $product)
                            @php
                                $isNew = $loop->index < 3 && now()->diffInDays($product->created_at) <= 7;
                            @endphp
    
                            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 border border-gray-200">
                                <a href="{{ route('product.details', $product->id) }}" class="block">
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover rounded-lg">
                                        @if ($isNew)
                                            <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded">
                                                New
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold text-lg mt-3 text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-blue-600 text-lg font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                                </a>
    
                                <div class="mt-4 flex items-center justify-between">
                                    <button wire:click="addToCart({{ $product->id }})"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all flex items-center justify-center w-full">
                                        🛒 Add to Cart
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('carousel', (adsCount) => ({
            currentIndex: 0,
            adsCount: adsCount, 
            startX: 0,
            endX: 0,
            touchStart(event) {
                this.startX = event.touches[0].clientX;
            },
            touchEnd(event) {
                this.endX = event.changedTouches[0].clientX;
                this.handleSwipe();
            },
            handleSwipe() {
                let diff = this.startX - this.endX;
                if (diff > 50) {
                    this.nextSlide();
                } else if (diff < -50) {
                    this.prevSlide();
                }
            },
            nextSlide() {
                this.currentIndex = (this.currentIndex + 1) % this.adsCount;
            },
            prevSlide() {
                this.currentIndex = (this.currentIndex - 1 + this.adsCount) % this.adsCount;
            },
            autoRotate() {
                if (this.adsCount > 0) {
                    setInterval(() => { this.nextSlide(); }, 5000);
                }
            },
            init() {
                this.autoRotate();
            }
        }));
    });
</script>
