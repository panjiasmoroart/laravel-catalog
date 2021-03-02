<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CatalogsController extends Controller
{
    public function index()
    {
        $products = Product::get();

        $categories = Category::noParent()->get();

        return view('catalogs.index', ['products' => $products, 'categories' => $categories]);
    }
}
