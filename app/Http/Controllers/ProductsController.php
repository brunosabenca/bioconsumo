<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        return $products->paginate(10);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store()
    {
        $product = Product::create(request()->validate([
            'name' => 'required|max:80|unique:products',
            'description' => 'required|max:255',
            'price' => 'required|integer'
        ]));

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
            'name' => 'required|max:80|unique:products',
            'description' => 'required|max:255',
            'price' => 'required|integer'
        ]));

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/products');
    }
}
