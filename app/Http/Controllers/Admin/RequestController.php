<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RequestController extends AppBaseController
{
    public $viewerRole, $publicanRole, $adminRole;
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin']);
        $this->viewerRole = Role::find(1);
        $this->adminRole = Role::find(2);
        $this->publicanRole = Role::find(4);
    }

    public function index()
    {
        $requests = ModelsRequest::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->sendRespondSuccess($requests, 'Get request successfully!');
    }

    public function accept(ModelsRequest $request)
    {
        if ($request->name === 'Publican') {
            $user = $request->user;
            if ($user->hasRole($this->viewerRole)) {
                $user->removeRole($this->viewerRole);
                $user->assignRole($this->publicanRole);
            } else return $this->sendRespondError($user, 'User is an publican', 500);
        }
        $request->status = 'accepted';
        $request->save();
        return $this->sendRespondSuccess($request, 'Accept successfully!');
    }

    public function cancel(ModelsRequest $request)
    {
        $request->status = 'canceled';
        $request->save();
        return $this->sendRespondSuccess($request, 'Cancel successfully!');
    }

    public function delete(ModelsRequest $request)
    {
        $request->delete();
        return $this->sendRespondSuccess($request, 'Delete request successfully!');
    }
}
