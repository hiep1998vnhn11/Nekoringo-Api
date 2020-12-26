<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get()
    {
        $notifications = auth()->user()->notifications()->orderBy('read_at', 'desc')->get();
        auth()->user()->unreadNotifications->markAsRead();
        return $this->sendRespondSuccess($notifications, 'Get successfully!');
    }

    public function getAmountUnread()
    {
        $unread = auth()->user()->unreadNotifications;
        $amount = count($unread);
        return $this->sendRespondSuccess($amount, 'Get successfully!');
    }
}
