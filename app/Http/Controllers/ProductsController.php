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
        $user = auth()->user();
        if ($user->hasRole('seller')) {
            $user->load('products');
            $products = $this->getUserProducts($user->id);
            $sellers = collect([$user]);
        } else {
            $products = $this->getProducts();
            $sellers = Seller::all();
        }

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

    public function getUserProducts($id)
    {
        $products = Product::latest()->with('seller')->where('user_id', $id)->get();

        return $products;
    }

    public function create()
    {
        $sellers = Seller::all();

        return view('products.create', [
            'sellers' => $sellers
        ]);
    }

    public function store()
    {
        $user = auth()->user();
        $user_id = $user->id;

        request()->validate([
            'name' => 'required|max:80|unique:products',
            'description' => 'required|max:255',
            'price' => 'required|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        if (! $user->hasRole('seller')) {
            request()->validate([
                'user_id' => 'required'
            ]);
            $user_id = request()['user_id'];
        }

        $product = Product::create([
            'name' => request()['name'],
            'description' => request()['description'],
            'price' => Money::parseByIntlLocalizedDecimal((string) request()['price'], 'EUR')->formatted(),
            'stock' => request()['stock'],
            'user_id' => request()['user_id']
        ]);


        $product->load('seller');

        if (request()->wantsJson()) {
            return response($product->toArray(), 201);
        }

        return redirect($product->path());
    }

    public function show(Product $product)
    {
        $user = auth()->user();
        if ($user->hasRole('seller') && $product->user_id !== $user->id) {
            if (request()->wantsJson()) {
                return response(['message' => "You don't have permission to view this product."], 403);
            }
            return redirect('/products')->with('flash-message', "You don't have permission to view this product.")->with('flash-level','danger');
        } else {
            $product->load('seller');
            return view('products.show', compact('product'));
        }
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
