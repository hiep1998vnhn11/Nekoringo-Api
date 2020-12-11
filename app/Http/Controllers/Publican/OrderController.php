<?php

namespace App\Http\Controllers\Publican;

use App\Http\Controllers\AppBaseController;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:publican']);
    }

    public function index()
    {
        $orders = auth()->user()->pubOrders;
        foreach ($orders as $order) {
            $order->user;
        }
        return $this->sendRespondSuccess($orders, 'Successfully!');
    }

    public function accept(Order $order)
    {
        $order->status = 'accepted';
        $order->save();
        return $this->sendRespondSuccess($order, 'Accept successfully!');
    }

    public function cancel(Order $order)
    {
        $order->status = 'canceled';
        $order->save();
        return $this->sendRespondSuccess($order, 'Cancel successfully!');
    }

    public function delete(Order $order)
    {
        $order->delete();
        return $this->sendRespondSuccess($order, 'Delete successfully!');
    }
}
