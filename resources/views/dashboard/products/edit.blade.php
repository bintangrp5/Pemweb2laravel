<x-layouts.app :title="__('Edit Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Edit Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage and Update Product Data</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
    <flux:badge color="lime" class="mb-3 w-full">{{ session()->get('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
    <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <flux:input label="Name" name="name" class="mb-3" placeholder="Product Name" value="{{ old('name', $product->name) }}" />
        <flux:select label="Category" name="category_slug" class="mb-3">
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" {{ $product->category->slug == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>

            @endforeach
        </flux:select>
        <flux:input label="Slug" name="slug" class="mb-3" placeholder="product-name" value="{{ old('slug', $product->slug) }}" />
        <flux:input label="SKU" name="sku" class="mb-3" placeholder="Stock Keeping Unit" value="{{ old('sku', $product->sku) }}" />
        <flux:textarea label="Description" name="description" class="mb-3" placeholder="Product Description">{{ old('description', $product->description) }}</flux:textarea>
        <flux:input label="Price" name="price" type="number" class="mb-3" placeholder="Product Price" value="{{ old('price', $product->price) }}" />
        <flux:input label="Stock" name="stock" type="number" class="mb-3" placeholder="Available Stock" value="{{ old('stock', $product->stock) }}" />
        
        <div class="mb-3">
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md" />
            @if ($product->image_url)
            <div class="mt-2">
                <img src="{{ asset($product->image_url) }}" alt="Product Image" class="w-32 h-32 object-cover">

                    <p class="text-sm text-gray-500 mt-2">Current Image</p>
                </div>
            @endif
        </div>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Update Product</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Back</flux:link>
        </div>
    </form>
</x-layouts.app>
