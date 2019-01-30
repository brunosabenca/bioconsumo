<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupOrder;

class GroupOrdersController extends Controller
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
            'open-date' => 'required|date|after_or_equal:today',
            'close-date' => 'required|date|after:open-date'
        ]);
        
        $overlaps = $this->getOverlapsCount(
            request()['open-date'],
            request()['close-date']
        );

        if ($overlaps === 0) {
            $group_order = GroupOrder::create([
                'open_date' => request('open-date'),
                'close_date' => request('close-date'),
            ]);
        } else {
            return redirect()->back()->with('flash-message', 'The dates you selected overlap with an existing order')->with('flash-level', 'danger');
        }

        if (request()->wantsJson()) {
            return response($group_order, 201);
        }

        return redirect($group_order->path());
    }

    public function getOverlapsCount($openDate, $closeDate)
    {

        //(StartA <= EndB) and (EndA >= StartB)
        // from https://stackoverflow.com/questions/325933/determine-whether-two-date-ranges-overlap
        $overlapsCount = GroupOrder::where('cancelled', false)->where(function ($query) use ($openDate, $closeDate) {
            $query->where(function ($query) use ($openDate, $closeDate) {
                    $query->where('open_date', '<=', $closeDate)
                    ->where('close_date', '>=', $openDate);
            });
        })->count();

        return $overlapsCount;
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
    public function update(GroupOrder $group_order)
    {
        $group_order->update(request()->validate([
            'open_date' => 'required',
            'close_date' => 'required'
        ]));

        return $group_order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupOrder $group_order)
    {
        $group_order->update([
            'cancelled' => true,
        ]);

        foreach ($group_order->orders as $order) {
            $order->update([
                'cancelled' => true,
            ]);
        }

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($group_order->path());
    }
}
