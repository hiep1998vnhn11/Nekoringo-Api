<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin']);
    }

    public function index()
    {
        $requests = ModelsRequest::where('status', 'pending')
            ->orderBy('created', 'desc')
            ->get();
        return $this->sendRespondSuccess($requests, 'Get request successfully!');
    }

    public function acceptRequest(ModelsRequest $request)
    {
        $request->status = 'accepted';
        $request->save();
        return $this->sendRespondSuccess($request, 'Accept successfully!');
    }

    public function cancelRequest(ModelsRequest $request)
    {
        $request->status = 'canceled';
        $request->save();
        return $this->sendRespondSuccess($request, 'Cancel successfully!');
    }
}
