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
                    <a href="/category/{{ $category['slug'] }}" class="btn
btn-primary">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-layout>