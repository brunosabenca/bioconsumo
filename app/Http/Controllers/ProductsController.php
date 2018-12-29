<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = $this->getProducts();

        if (request()->wantsJson())
        {
            return $products;
        }


        return view('products.index', [
            'products' => $products
        ]);
    }

    public function getProducts()
    {
        $products = Product::latest();

        return $products->paginate(3);
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
