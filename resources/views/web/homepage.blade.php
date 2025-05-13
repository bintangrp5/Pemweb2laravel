<x-layout>
    <div class="container mt-4">

        {{-- Categories Section --}}
        <h3 class="mb-3">Categories</h3>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="card-img-top" style="height: 200px; object-fit: cover; object-position: center;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text">{{ $category->description }}</p>
                        <div class="mt-auto">
                            <a href="/category/{{ $category->slug }}" class="btn btn-primary w-100">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <hr>

        {{-- Products Section --}}
        <h3 class="mb-3 mt-5">Products</h3>
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover; object-position: center;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                        <p class="card-text"><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                        <div class="mt-auto">
                            <a href="/product/{{ $product->slug }}" class="btn btn-success w-100">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</x-layout>
