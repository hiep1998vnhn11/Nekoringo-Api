<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Pub;
use Illuminate\Http\Request;

class OrderController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:viewer']);
    }

    public function index()
    {
        $orders = auth()->user()->orders;
        foreach ($orders as $order) {
            $order->user;
            $order->pub;
        }
        return $this->sendRespondSuccess($orders, 'Get successfully!');
    }

    public function create(OrderRequest $request, Pub $pub)
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->pub_id = $pub->id;
        $order->time = $request->time;
        $order->amount = $request->amount;
        $order->save();
        return $this->sendRespondSuccess($order, 'Make order successfully!');
    }

    public function delete(Order $order)
    {
        if ($order->user_id != auth()->user()->id) return $this->sendForbidden();
        else {
            $order->delete();
            return $this->sendRespondSuccess($order, 'Delete order successfully!');
        }
    }
}
