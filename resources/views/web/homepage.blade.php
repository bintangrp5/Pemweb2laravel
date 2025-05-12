<x-layout>
    <div class="row">
        <h3>Categories</h3>
        @foreach($categories as $category)
        <div class="col-2">
            <div class="card">
                <img src="{{ $category['image'] }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $category['name'] }}</h5>
                    <p class="card-text">
                        {{ $category['description'] }}
                    </p>
                    <a href="/category/{{ $category['slug'] }}" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <hr>

    <div class="row mt-4">
        <h3>Products</h3>
        @foreach($products as $product)
        <div class="col-3">
            <div class="card">
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                    <p class="card-text"><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                    <a href="/product/{{ $product->slug }}" class="btn btn-success">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-layout>
