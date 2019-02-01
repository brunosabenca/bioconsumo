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
        $products = Product::latest()->with('seller')->get();

        return $products;
    }

    public function create()
    {
        $sellers = \App\Seller::all();

        return view('products.create', [
            'sellers' => $sellers
        ]);
    }

    public function store()
    {
        $product = Product::create(request()->validate([
            'name' => 'required|max:80|unique:products',
            'description' => 'required|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'user_id' => 'required'
        ]));

        if (request()->wantsJson()) {
            return response($product, 201);
        }

        return redirect($product->path());
    }

    public function show(Product $product)
    {
        $product->load('seller');
        return view('products.show', compact('product'));
    }

    public function update(Product $product)
    {
        $product->update(request()->validate([
            'name' => 'required|max:80',
            'description' => 'required|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer'
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
