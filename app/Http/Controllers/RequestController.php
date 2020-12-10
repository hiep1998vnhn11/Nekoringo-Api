<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'role:viewer']);
    }

    public function makePublicanRequest()
    {
        $requests = auth()->user()->requests()->where('name', 'Publican')->first();
        if ($requests) return $this->sendRespondError($requests, 'You had been requested to server!');
        $request = new ModelsRequest();
        $request->name = 'Publican';
        $request->user_id = auth()->user()->id;
        $request->save();
        return $this->sendRespondSuccess($request, 'Make publican request successfully!');
    }
}
