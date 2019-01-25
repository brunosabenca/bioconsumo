<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserOrder;
use App\Product;
use App\CartItem;

class CartController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_order = auth()->user()->orders()
            ->where('delivered', false)
            ->where('cancelled', false)
            ->where('open', true)
            ->first();

        if ($user_order) {
            return $user_order->items;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product)
    {
        $user_order = auth()->user()->orders()
            ->where('delivered', false)
            ->where('cancelled', false)
            ->where('open', true)
            ->first();

        if ($user_order == null) {
            return redirect()->back()
                ->with('flash-message', "Couldn't add product because there is no order open.")
                ->with('flash-level', 'warning');
        } else {
            //TODO: Check if the product is already in the cart before adding it!
            $item = CartItem::create([
                'user_order_id' => $user_order->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);

            return redirect($user_order->path())->with('flash-message', $item->product->name . ' added to your order.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
