<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupOrder;

class GroupOrdersController extends Controller
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

        return view('group_orders.index', [
            'orders' => $orders
        ]);
    }

    public function getOrders()
    {
        $orders = GroupOrder::latest();

        return $orders->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group_orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'open-date' => 'required',
            'close-date' => 'required'
        ]);

        $group_order = GroupOrder::create([
            'open_date' => request('open-date'),
            'close_date' => request('close-date')
        ]);

        if (request()->wantsJson()) {
            return response($group_order, 201);
        }

        return redirect($group_order->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(GroupOrder $order)
    {
        return view('group_orders.show', compact('order'));
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
    public function update(Order $order)
    {
        $order->update(request()->validate([
            'open_date' => 'required',
            'close_date' => 'required',
        ]));

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupOrder $order)
    {
        $order->cancelled = true;
        $order->save();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/orders');
    }
}
