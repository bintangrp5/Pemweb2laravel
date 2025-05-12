<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $products = Product::when($q, function ($query) use ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%");
        })->latest()->paginate(10);

        return view('dashboard.products.index', compact('products', 'q'));
    }

    public function create()
    {
        $categories = Categories::all(); // Ambil semua kategori
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_slug' => 'required|string|exists:product_categories,slug',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Ambil ID kategori dari slug
        $category = Categories::where('slug', $request->category_slug)->first();

        // Menyimpan file gambar langsung ke folder public/images
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' .
                $image->getClientOriginalExtension(); // Menentukan nama file gambar
            $imagePath = public_path('images'); // Folder penyimpanan gambar

            // Menyimpan gambar di folder public/images
            $image->move($imagePath, $imageName);

            // Menyimpan path gambar relatif
            $imageUrl = 'images/' . $imageName;
        }

        // Buat SKU unik
        $sku = strtoupper(Str::random(8));
        while (Product::where('sku', $sku)->exists()) {
            $sku = strtoupper(Str::random(8));
        }

        // Buat slug produk dari nama produk
        $slug = Str::slug($request->slug);
        while (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(3); // optional: jika ingin tetap menjamin unik
        }


        // Simpan produk
        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'sku' => $sku,
            'product_category_id' => $category->id,
            'image_url' => $imageUrl,
            'is_active' => ((int) $request->stock > 0),
        ]);


        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Disimpan');
    }

    public function edit(Product $product)
    {
        $categories = Categories::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_slug' => 'required|string|exists:product_categories,slug',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Ambil ID kategori dari slug
        $category = Categories::where('slug', $request->category_slug)->first();

        // Update slug (buat baru dari nama, lalu pastikan unik)
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $originalSlug . '-' . Str::random(3);
        }

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images');

            // Hapus gambar lama jika ada
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                unlink(public_path($product->image_url));
            }

            // Pindahkan file gambar baru
            $image->move($imagePath, $imageName);

            $imageUrl = 'images/' . $imageName;
        } else {
            $imageUrl = $product->image_url; // Gunakan gambar lama jika tidak diubah
        }

        // Update data produk
        $product->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'product_category_id' => $category->id,
            'image_url' => $imageUrl,
            'is_active' => ((int) $request->stock > 0),
        ]);

        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Disimpan');
    }


    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('successMessage', 'Product deleted successfully.');
    }
}
