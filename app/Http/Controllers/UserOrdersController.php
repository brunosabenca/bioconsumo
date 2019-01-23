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
        $user_order = auth()->user()->orders()->where('delivered', false)->first();
        $group_order = GroupOrder::where('cancelled', false)->latest()->first();

        if ($user_order === null) {
            $group_order = GroupOrder::where('cancelled', false)->latest()->first();
            $user_order = UserOrder::create([
                'group_order_id' => $group_order->id,
                'user_id' => auth()->user()->id
            ]);
        } elseif ($group_order !== null) {
            $this->update_group_order($user_order, $group_order);
        }


        return view('user_orders.show', [
            'group_order' => $group_order
        ]);
    }

    public function update_group_order(UserOrder $user_order, GroupOrder $group_order)
    {
        if ($group_order !== null) {
            $current_group_order = GroupOrder::where('id', $user_order->group_order_id)->first();

            if ($group_order->cancelled) {
                $user_order->group_order_id = $group_order->id;
            }
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
        //
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
