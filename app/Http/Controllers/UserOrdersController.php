<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupOrder;
use App\UserOrder;

class UserOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->getOrders();

        if (request()->wantsJson()) {
            return $orders;
        }

        return view('user_orders.index', [
            'orders' => $orders
        ]);
    }

    public function getOrders()
    {
        $orders = UserOrder::latest();

        return $orders->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_order = auth()->user()->orders()->where('delivered', false)->where('cancelled', false)->first();

        if ($user_order) {
            return redirect($user_order->path());
        } else {
            $group_orders = GroupOrder::where('open', true)->latest()->get();

            return view('user_orders.create', [
                'group_orders' => $group_orders,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'group_order' => 'required',
        ]);

        $user_order = UserOrder::create([
            'group_order_id' => request()->group_order,
            'user_id' => auth()->user()->id
        ]);

        if (request()->wantsJson()) {
            return response($user_order, 201);
        }

        return redirect($user_order->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserOrder $user_order)
    {
        $group_order = GroupOrder::where('id', '=', $user_order->group_order_id)->first();

        return view('user_orders.show', [
            'user_order' => $user_order,
            'group_order' => $group_order
        ]);
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
    public function destroy(UserOrder $user_order)
    {
        $user_order->cancelled = true;
        $user_order->save();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/user/orders/create');
    }
}
