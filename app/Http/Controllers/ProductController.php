<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getCategoriesByProduct($id, Request $request) {
        $categories = Product::find($id)->categories;
        return $categories;
    }
}
