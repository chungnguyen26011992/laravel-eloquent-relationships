<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getProductByCategory($id, Request $request) {
        $products = Category::find($id)->products;
        return $products;
    }
}
