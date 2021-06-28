<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'order',
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'category_product', 'product_id', 'category_id');
    }
}
