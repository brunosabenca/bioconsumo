<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupOrder;
use App\UserOrder;
use App\Product;

class UserOrdersController extends Controller
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
        $user_order = $this->getActiveOrder();

        if ($user_order) {
            return redirect($user_order->path());
        } else {
            $group_orders = GroupOrder::where('open', true)->latest()->get();

            if ($group_orders->count() === 1) {
                $user_order = $this->createNewUserOrder($group_orders->first()->id);
                return redirect($user_order->path())
                    ->with('flash-message', 'A new order was created');
            } else {
                return view('user_orders.create', [
                    'group_orders' => $group_orders,
                ]);
            }
        }
    }

    public function getActiveOrder()
    {
        $user_order = auth()->user()->orders()
            ->where('delivered', false)
            ->where('cancelled', false)
            ->where('open', true)
            ->first();

        return $user_order;
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

        $user_order = $this->createNewUserOrder(request()['group_order']);

        if (request()->wantsJson()) {
            return response($user_order, 201);
        }

        return redirect($user_order->path())
            ->with('flash-message', 'A new order was created');
    }

    protected function createNewUserOrder(int $group_order_id)
    {
        $user_order = UserOrder::create([
            'group_order_id' => $group_order_id,
            'user_id' => auth()->user()->id,
            'open' => true
        ]);

        return $user_order;
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

        $withProducts = request()->query('withProducts');

        if ($withProducts) {
            return view('user_orders.withProducts.show', [
                    'user_order' => $user_order,
                    'group_order' => $group_order,
                    'products' => Product::latest()->paginate(6),
                    'items' => $user_order->items
                ]);
        } else {
            return view('user_orders.show', [
                'user_order' => $user_order,
                'group_order' => $group_order,
                'products' => Product::latest()->paginate(6),
                'items' => $user_order->items
            ]);
        }
    }

    /**
     * Redirects to the currently active order page.
     */
    public function showCurrent()
    {
        $user_order = $this->getActiveOrder();

        if ($user_order) {
            return redirect($user_order->path());
        } else {
            return redirect(route('user_order.create'))
                ->with('flash-message', 'Please create a new order first')
                ->with('flash-level', 'warning');
        }
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
    public function update(UserOrder $user_order)
    {
        request()->validate([
            'open' => 'required|bool',
            'cancelled' => 'bool'
        ]);

        $user_order->update(request()->only('open'));

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($user_order->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOrder $user_order)
    {
        $user_order->update([
            'cancelled' => true,
            'open' => false,
        ]);

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($user_order->path())
            ->with('flash-message', 'The order has been cancelled.')
            ->with('flash-level', 'danger');
    }
}
