<x-layout>
    <x-slot:title>{{ $title }}</x-slot>
        <h3 class="text-center mb-3 mt-3">New Balance</h3>
        <x-card></x-card>
        <x-alert></x-alert>
        <div class="row justify-content-center" style="margin-bottom: 40px;">
            <h3 class="text-center mb-4">Categories</h3>
            @foreach($categories as $category)
            <div class="col-2">
                <div class="card">
                    <img src="{{ $category['image'] }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category['name'] }}</h5>
                        <p class="card-text">
                            {{ $category['description'] }}
                        </p>
                        <a href="/category/{{ $category['slug'] }}" class="btn
btn-primary">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
</x-layout>