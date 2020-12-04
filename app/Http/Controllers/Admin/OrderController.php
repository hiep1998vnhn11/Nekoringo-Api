<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin']);
    }

    public function index()
    {
        $orders = Order::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->sendRespondSuccess($orders, 'Get orders successfully!');
    }

    public function delete(Order $order)
    {
        $order->delete();
        return $this->sendRespondSuccess($order, 'Delete successfully!');
    }

    public function cancel(Order $order)
    {
        $order->status = 'canceled';
        $order->save();
        return $this->sendRespondSuccess($order, 'Canceled!');
    }

    public function accept(Order $order)
    {
        $order->status = 'accepted';
        $order->save();
        return $this->sendRespondSuccess($order, 'Accepted!');
    }
}
