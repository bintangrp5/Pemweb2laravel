<?php

namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
class Categories
{
    //ibaratkan ini ada list data yang ada di database
    private static $product_categories = [
        [
            'id' => 1,
            'name' => 'pria',
            'slug' => 'pria', 
            'description' => 'Ini adalah produk pakaian pria',
            'image' => 'https://placehold.co/300x300?text=Pakaian+Pria',
        ],
        [
            'id' => 2,
            'name' => 'wanita',
            'slug' => 'wanita',
            'description' => 'Ini adalah produk pakaian wanita',
            'image' => 'https://placehold.co/300x300?text=Pakaian+Wanita',
        ],
        [
            'id' => 3,
            'name' => 'anak-anak',
            'slug' => 'anak-anak',
            'description' => 'Ini adalah produk pakaian anak-anak',
            'image' => 'https://placehold.co/300x300?text=Pakaian+Anak-Anak',
        ],
        [
            'id' => 4,
            'name' => 'aksesori',
            'slug' => 'Aksesori',
            'description' => 'Ini adalah produk aksesori',
            'image' => 'https://placehold.co/300x300?text=Aksesori',
        ],
        [
            'id' => 5,
            'name' => 'sepatu',
            'slug' => 'Sepatu',
            'description' => 'Ini adalah produk sepatu',
            'image' => 'https://placehold.co/300x300?text=Sepatu',
        ]
    ];
    //kita buatkan function untuk mengambil data dari array diatas
    public static function all()
    {
        return collect(self::$product_categories);
    }

    public static function find($slug)
    {
        $categories = static::all();
        return $categories->firstWhere('slug', $slug);
    }
       
       
}
