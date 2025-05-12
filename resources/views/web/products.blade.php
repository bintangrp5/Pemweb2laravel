<x-layout>
    

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
