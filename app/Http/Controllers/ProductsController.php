<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = $this->getProducts();

        if (request()->wantsJson()) {
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

    public function create()
    {
        return view('products.create');
    }

    public function store()
    {
        request()->validate([
            'product-name' => 'required',
            'product-description' => 'required',
            'product-price' => 'required'
        ]);

        $product = Product::create([
            'name' => request('product-name'),
            'description' => request('product-description'),
            'price' => request('product-price')
        ]);

        if (request()->wantsJson()) {
            return response($product, 201);
        }

        return redirect($product->path());
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function update(Product $product)
    {
        $product->update(request()->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]));

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        if ($request->wantsJson()) {
            return response([], 204);
        }

        return redirect('/products');
    }
}
