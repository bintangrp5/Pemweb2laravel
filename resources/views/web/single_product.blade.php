<x-layout>
    <x-slot:title>{{ $title }}</x-slot>

        <div class="container py-5">
            <div class="row">
                
                <div class="col-md-6">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-6">
                    <span class="badge bg-secondary mb-2">{{ strtoupper($product->category->name ?? 'Kategori Tidak Tersedia') }}</span>
                    <h2 class="fw-bold">{{ strtoupper($product->name) }}</h2>
                    <h4 class="text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>

                    <p class="mt-3">
                        <strong>Stok:</strong>
                        @if ($product->is_active && $product->stock > 0)
                        {{ $product->stock }}
                        @else
                        <span class="text-red-600 font-semibold">Habis</span>
                        @endif
                        <br>
                        <strong>SKU:</strong> {{ $product->sku }}
                    </p>

                    <div class="mt-4">
                        <button class="btn btn-dark w-100 py-2"
                            {{ !$product->is_active || $product->stock == 0 ? 'disabled' : '' }}>
                            Tambah ke keranjang
                        </button>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded">
                        <p class="mb-1"><strong>📦 Gratis Pengiriman</strong> <br><small>Minimal Pembelanjaan Rp 200.000,-</small></p>
                        <hr>
                        <p class="mb-0"><strong>🛡️ Garansi Sampai 1 Tahun</strong><br><small>Dapatkan Garansi untuk Produk Tertentu sampai dengan 1 Tahun setelah Pembelanjaan</small></p>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="fw-semibold">Tentang Produk</h4>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>
</x-layout>

