<div>
    <h2 class="text-xl font-bold">Available Services</h2>
    <ul>
        @foreach ($services as $service)
            <li>
                <a href="{{ route('service.book', $service->id) }}" class="text-blue-500">{{ $service->name }} - ${{ $service->price }}</a>
            </li>
        @endforeach
    </ul>
</div>
