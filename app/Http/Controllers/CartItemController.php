<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserOrder;
use App\Product;
use App\CartItem;

class CartItemController extends Controller
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
        request()->validate(['quantity' => 'required|numeric|min:1']);

        $group_order = $this->getActiveGroupOrder();
        if ($group_order) {
            $user_order = UserOrder::firstOrCreate(
                [
                    'user_id' => auth()->user()->id,
                    'delivered' => false,
                    'cancelled' => false,
                ],
                [
                    'group_order_id' => $group_order->id
                ]
            );
        } else {
            return redirect()->back()->with('flash-message', 'There is currently no active group order')->with('flash-level', 'danger');
        }

        $item = $this->findCartItemInOrderByProductId($user_order->id, $product->id);
        if ($item == null) {
            $item = CartItem::create([
                'user_order_id' => $user_order->id,
                'product_id' => $product->id,
                'quantity' => request()['quantity'],
            ]);
            return redirect($user_order->path())->with('flash-message', $item->product->name . ' added to your order');
        } else {
            $item->incrementQty(request()['quantity']);
            return redirect($user_order->path())->with('flash-message', $product->name . "'s quantity updated to " . $item->quantity);
        }
    }

    protected function getActiveGroupOrder()
    {
            $group_orders = \App\GroupOrder::where('cancelled', false)->latest()->get();

            foreach ($group_orders as $order) {
                if ($order->isActive) {
                    return $order;
                }
            }
            
            return null;
    }

    protected function findCartItemInOrderByProductId(int $userOrderId, int $productId)
    {
        return CartItem::where('user_order_id', $userOrderId)->where('product_id', $productId)->first();
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
    public function update(CartItem $item)
    {
        request()->validate([
            'quantity' => 'required|numeric|min:0'
        ]);
        
        if ($item->update(request()->only('quantity'))) {
            if (request()->wantsJson()) {
                return response($item->price, 201);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $item)
    {
        $deleted = $item->delete();

        if (request()->expectsJson()) {
            if ($deleted) {
                return response(['status' => 'Item deleted']);
            } else {
                return response(['status' => 'Error deleting item']);
            }
        }

        return redirect($item->order->path());
    }
}
