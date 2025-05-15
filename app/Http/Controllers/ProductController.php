<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;



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
        $categories = Categories::all();
        return view('dashboard.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_slug' => 'required|string|exists:product_categories,slug',
            'slug' => 'required|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:50|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $category = Categories::where('slug', $validated['category_slug'])->first();

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images');
            $image->move($imagePath, $imageName);
            $imageUrl = 'images/' . $imageName;
        }

        Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'sku' => $validated['sku'],
            'product_category_id' => $category->id,
            'image_url' => $imageUrl,
            'is_active' => ((int) $validated['stock'] > 0),
        ]);

        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Disimpan');
    }


    public function show(Product $product)
    {
        return view('dashboard.products.index', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Categories::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category_slug' => 'required|string|exists:product_categories,slug',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        $validated = $request->validate($rules);

        $category = Categories::where('slug', $validated['category_slug'])->first();

        $slug = Str::slug($validated['slug'] ?? $validated['name']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images');

            if ($product->image_url && file_exists(public_path($product->image_url))) {
                unlink(public_path($product->image_url));
            }

            $image->move($imagePath, $imageName);
            $imageUrl = 'images/' . $imageName;
        } else {
            $imageUrl = $product->image_url;
        }

        $product->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $validated['sku'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'product_category_id' => $category->id,
            'image_url' => $imageUrl,
            'is_active' => ((int) $validated['stock'] > 0),
        ]);

        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Diperbarui');
    }


    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('successMessage', 'Data Berhasil Dihapus');
    }
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->back()->with('success', 'Status produk berhasil diperbarui.');
    }
}
