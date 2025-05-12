<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
    <flux:badge color="lime" class="mb-3 w-full">{{ session()->get('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
    <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <flux:input label="Name" name="name" class="mb-3" placeholder="Product Name" />
        <flux:select label="Category" name="category_slug" class="mb-3">
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}">{{ $category->name }}</option>
            @endforeach
        </flux:select>
        <flux:input label="Slug" name="slug" class="mb-3" placeholder="product-name" />

        <flux:textarea label="Description" name="description" class="mb-3" placeholder="Product Description" />
        <flux:input label="Price" name="price" type="number" class="mb-3" placeholder="Product Price" />
        <flux:input label="Stock" name="stock" type="number" class="mb-3" placeholder="Available Stock" />
        <flux:input type="file" label="Image" name="image" class="mb-3" />
        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>