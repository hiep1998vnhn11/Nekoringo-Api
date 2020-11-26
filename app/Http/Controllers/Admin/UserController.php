<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class UserController extends AppBaseController
{
    public $viewerRole, $blockedRole, $adminRole;
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->viewerRole = Role::find(1);
        $this->adminRole = Role::find(2);
        $this->blockedRole = Role::find(3);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewRole = Role::whereNotIn('name', ['admin'])->get();
        $users = User::role($viewRole)->with('roles')->get();
        return $this->sendRespondSuccess($users, 'Get user successfully!');
    }

    /**
     * Create an user
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateUserRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return $this->sendRespondSuccess($user, 'Create user successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->sendRespondSuccess($user, 'Get user successfully!');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->hasRole($this->adminRole))
            return $this->sendForbidden();
        $user->delete();
        return $this->sendRespondSuccess($user, 'Delete user successfully!');
    }

    /**
     * Blocked User
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block(User $user)
    {
        if ($user->hasRole($this->viewerRole)) {
            $user->removeRole($this->viewerRole);
            $user->assignRole($this->blockedRole);
        } else return $this->sendRespondError($user, 'User is blocking yet', 500);
        return $this->sendRespondSuccess($user, 'Block successfully!');
    }
}
