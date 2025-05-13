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


    public function products()
    {
        $title = "Products";
        $products = Product::with('category')->latest()->paginate(12);

        return view('web.products', [
            'title' => $title,
            'products' => $products,
        ]);
    }

    public function product($slug)
    {
        $title = "product";
        return view('web.product', ['title' => $title, 'slug' => $slug]);
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
