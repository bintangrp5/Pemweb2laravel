<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;


use Illuminate\Http\Request;

use function Livewire\Volt\title;

class HomepageController extends Controller
{
    // fungsi untuk menampilkan halaman homepage
    public function index()
    {
        $categories = Categories::all();
        $products = Product::latest()->take(8)->get();
        $title = "homepage";


        return view('web.homepage', [
            'title' => $title,
            'categories' => $categories,
            'products' => $products,
        ]);
    }
    public function category($slug)
    {
        $category = Categories::where('slug', $slug)->with('products')->firstOrFail();

        return view('web.category_by_slug', [
            'category' => $category
        ]);
    }

public function products(Request $request)
{
    $title = "Products";
    $query = Product::with('category')
        ->where('is_active', true) 
        ->latest();

    if ($request->has('q') && $request->q !== '') {
        $query->where('name', 'like', '%' . $request->q . '%');
    }
    $products = $query->paginate(12);

    return view('web.products', compact('title', 'products'));
}

    public function product($slug)
{
    $product = Product::where('slug', $slug)->with('category')->firstOrFail();
    $title = $product->name;

    return view('web.single_product', [
        'title' => $title,
        'product' => $product
    ]);
}

    public function categories()
    {
        $categories = Categories::all();

        return view('web.categories', [
            'categories' => $categories
        ]);
    }

    public function cart()
    {
        return view('web.cart');
    }

    public function checkout()
    {
        return view('web.checkout');
    }
}
