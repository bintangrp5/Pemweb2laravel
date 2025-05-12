<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products'; // Sesuaikan dengan nama tabel 
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'sku',
        'product_category_id', 
        'image_url',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'product_category_id');
    }
}
