<div class="container mx-auto p-6">
    <div x-data="carousel({{ count($ads ?? []) }})" class="relative w-full overflow-hidden">
        <div class="flex transition-transform duration-500 ease-in-out" :style="'transform: translateX(-' + (currentIndex * 100) + '%)'" wire:ignore.self>
            @foreach($ads as $index => $ad)
                <div class="w-full flex-shrink-0 relative">
                    <a href="{{ $ad->link }}">
                        <!-- Ad Container -->
                        <div class="relative">
                            <!-- Ad Image -->
                            <img src="{{ asset('storage/' . $ad->image) }}" class="w-full h-64 object-cover">
                            <!-- Ad Text Title -->
                            <div class="absolute bottom-12 left-4 text-white text-lg bg-black bg-opacity-50 p-2">
                                {{ $ad->title }}
                            </div>
                            <!-- Ad Text Description -->
                            <div class="absolute bottom-2 left-4 text-white text-sm bg-black bg-opacity-50 p-2">
                                {{ $ad->text }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Navigation Dots -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach($ads as $index => $ad)
                <div class="w-3 h-3 rounded-full cursor-pointer"
                    :class="currentIndex === {{ $index }} ? 'bg-white' : 'bg-gray-400'"
                    @click="currentIndex = {{ $index }}">
                </div>
            @endforeach
        </div>

        <!-- Navigation Arrows -->
        <button @click="prevSlide" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white bg-black bg-opacity-50 p-2">
            &#10094;
        </button>
        <button @click="nextSlide" class="absolute right-0 top-1/2 transform -translate-y-1/2 text-white bg-black bg-opacity-50 p-2">
            &#10095;
        </button>

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
    </div>
    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-3 mt-3">
            {{ session('success') }}
        </div>
    @endif
    
    <h2 class="text-2xl font-bold mb-4">Shop Products</h2>

    <!-- Filters -->
    <div class="mb-6 flex space-x-4">
        <input type="text" wire:model.debounce.500ms="search" class="border p-2 w-1/3" placeholder="Search products...">
        
        <select wire:model="categoryFilter" class="border p-2">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <input type="number" wire:model.live="minPrice" class="border p-2 w-1/6" placeholder="Min Price">
        <input type="number" wire:model.live="maxPrice" class="border p-2 w-1/6" placeholder="Max Price">
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="border p-4 shadow">
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover mb-2">
                <h3 class="font-bold">{{ $product->name }}</h3>
                <p class="text-gray-500">${{ number_format($product->price, 2) }}</p>
                <button wire:click="addToCart({{ $product->id }})"
                    class="bg-blue-500 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700">
                    Add to Cart
                </button>
                <a href="{{ route('product.details', $product->id) }}" class="text-blue-500">View Details</a>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
