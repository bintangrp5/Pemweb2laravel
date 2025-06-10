<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Products</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Search & Add New Product --}}
    <div class="flex justify-between items-center mb-4">
        <form action="{{ route('products.index') }}" method="get">
            @csrf
            <flux:input icon="magnifying-glass" name="q" value="{{ $q ?? '' }}" placeholder="Search Products" />
        </form>
        <flux:button icon="plus">
            <flux:link href="{{ route('products.create') }}" variant="subtle">Add New Product</flux:link>
        </flux:button>
    </div>

    {{-- Success Message --}}
    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">
            {{ session()->get('successMessage') }}
        </flux:badge>
    @endif

    {{-- Products Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    @foreach(['ID', 'Image', 'Name', 'Slug', 'SKU', 'Harga (Rp)', 'Stock', 'Status', 'Created At', 'Actions'] as $heading)
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            {{ $heading }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $product)
                    <tr>
                        {{-- ID --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $key + 1 }}</p>
                        </td>

                        {{-- Image --}}
                        <td class="px-5 py-5 border-b text-sm">
                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full">
                            @else
                                <div class="h-10 w-10 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">N/A</span>
                                </div>
                            @endif
                        </td>

                        {{-- Name --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $product->name }}</p>
                        </td>

                        {{-- Slug --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $product->slug }}</p>
                        </td>

                        {{-- SKU --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $product->sku }}</p>
                        </td>

                        {{-- Price --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                Rp{{ number_format($product->price, 2, ',', '.') }}
                            </p>
                        </td>

                        {{-- Stock --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $product->stock }}</p>
                        </td>

                        {{-- Status & Toggle --}}
                        <td class="px-5 py-5 border-b text-sm">
                            @php
                                $isActive = $product->is_active;
                                $statusClass = $isActive ? 'bg-green-200 text-green-900' : 'bg-red-200 text-red-900';
                                $statusText = $isActive ? 'Tersedia' : 'Tidak Aktif';
                                $buttonText = $isActive ? 'Nonaktifkan' : 'Aktifkan';
                                $isStockZero = $product->stock == 0;
                            @endphp

                            <span class="inline-block min-w-[80px] text-center px-3 py-1 rounded-full text-sm font-medium shadow-sm {{ $statusClass }}">
                                {{ $statusText }}
                            </span>

                            @if ($isStockZero && !$isActive)
                                <button type="button" class="text-gray-500 font-semibold py-1 px-3 rounded cursor-not-allowed mt-2" disabled>
                                    {{ $buttonText }}
                                </button>
                            @else
                                <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-gray-800 font-semibold py-1 px-3 rounded">
                                        {{ $buttonText }}
                                    </button>
                                </form>
                            @endif
                        </td>

                        {{-- Created At --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $product->created_at }}</p>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-5 border-b text-sm">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('products.edit', $product->id) }}">
                                        Edit
                                    </flux:menu.item>
                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-form-{{ $product->id }}').submit();"
                                    >
                                        Delete
                                    </flux:menu.item>
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.app>
