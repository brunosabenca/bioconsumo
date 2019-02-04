<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Seller;
use Cknow\Money\Money;

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
        $sellers = Seller::all();

        if (request()->wantsJson()) {
            return $products;
        }

        return view('products.index', [
            'products' => $products,
            'sellers' => $sellers
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
        request()->validate([
            'name' => 'required|max:80|unique:products',
            'description' => 'required|max:255',
            'price' => 'required|min:0',
            'stock' => 'required|integer|min:0',
            'user_id' => 'required'
        ]);

        $product = Product::create([
            'name' => request()['name'],
            'description' => request()['description'],
            'price' => Money::parseByIntlLocalizedDecimal((string) request()['price'], 'EUR'),
            'stock' => request()['stock'],
            'user_id' => request()['user_id']
        ]);

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
        $user = auth()->user();
        $productBelongsToAuthenticatedUser = optional($user->products)->contains($product->id);
        
        if ($productBelongsToAuthenticatedUser || $user->can('edit any product')) {
           request()->validate([
                'name' => 'required|max:80',
                'description' => 'required|max:255',
                'price' => 'required',
                'stock' => 'required|integer'
            ]);

            $product->name = request()['name'];
            $product->description = request()['description'];
            $product->price = Money::parseByIntlLocalizedDecimal((string) request()['price'], 'EUR');
            $product->stock = request()['stock'];
            $product->save();

            if (request()->wantsJson()) {
                return response([], 204);
            }
        } else {
            if (request()->wantsJson()) {
                return response([], 403);
            }
        }

        return $product;
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();
        $productBelongsToAuthenticatedUser = optional($user->products)->contains($product->id);
        
        if ($productBelongsToAuthenticatedUser || $user->can('delete any product')) {
            $product->delete();

            if (request()->wantsJson()) {
                return response([], 204);
            }
        } else {
            if (request()->wantsJson()) {
                return response([], 403);
            }
        }

        return redirect('/products');
    }
}
