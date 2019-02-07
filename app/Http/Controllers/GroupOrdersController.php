<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupOrder;
use App\Seller;

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
        $group_orders = $this->getOrders();
        $sellers = Seller::all();

        if (request()->wantsJson()) {
            return $group_orders;
        }


        return view('group_orders.index', [
            'group_orders' => $group_orders,
            'sellers' => $sellers
        ]);
    }

    public function getOrders()
    {
        $group_orders = GroupOrder::latest()->with('sellers')->get();

        return $group_orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sellers = Seller::all();

        return view('group_orders.create',[
            'sellers' => $sellers
        ]);
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
            'open_date' => 'required|date|after_or_equal:today',
            'close_date' => 'required|date|after:open_date',
            'active_sellers' => 'required'
        ]);
        
        $overlaps = $this->getOverlapsCount(
            request()['open_date'],
            request()['close_date']
        );

        if ($overlaps === 0) {
            $group_order = GroupOrder::create([
                'open_date' => request('open_date'),
                'close_date' => request('close_date'),
            ]);
            $group_order->sellers()->sync(request('active_sellers'));
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'open_date' => ['The interval selected must not overlap with an existing order.'],
                'close_date' => ['The interval selected must not overlap with an existing order.'],
            ]);
            throw $error;
        }

        $group_order->load('sellers');

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
    public function show(GroupOrder $group_order)
    {
        $group_order->load('sellers');
        $sellers = Seller::all();
        
        return view('group_orders.show', [
            'group_order' => $group_order,
            'sellers' => $sellers
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
    public function update(GroupOrder $group_order)
    {
        $group_order->update(request()->validate([
            'open_date' => 'required|date|after_or_equal:today',
            'close_date' => 'required|date|after:open_date',
        ]));

        return $group_order->append('is_active');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupOrder $group_order)
    {
        $this->cancelGroupOrder($group_order);

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($group_order->path());
    }

    protected function cancelGroupOrder(GroupOrder $group_order)
    {
        $group_order->update([
            'cancelled' => true,
        ]);

        foreach ($group_order->orders as $group_order) {
            $group_order->update([
                'cancelled' => true,
            ]);
        }
    }
}
