<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Pub;
use App\Http\Requests\PubRequest;
use Illuminate\Support\Facades\Storage;

class PubController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pubs = Pub::orderBy('created_at', 'desc')->paginate(6);
        return $this->sendRespondSuccess($pubs, 'Get pub successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PubRequest $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PubRequest $request)
    {
        $pub = new Pub();
        $pub->user_id = auth()->user()->id;
        $pub->name = $request->name;
        $pub->main_email = $request->main_email;
        $pub->phone_number = $request->phone_number;
        $pub->description = $request->description;
        $pub->business_time = $request->business_time;
        $pub->address = $request->address;
        $pub->map_path = $request->map_path;
        $pub->video_path = $request->video_path;
        $pub->home_photo_path = 'https://www.événementiel.net/wp-content/uploads/2014/02/default-placeholder.png';
        $pub->save();
        $image_photo_path = null;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'pubs/' . $pub->id . '/home_image';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
        }
        if ($path) {
            $pub->home_photo_path = $path;
            $pub->save();
        }
        return $this->sendRespondSuccess($pub, 'Create Pub successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pub $pub)
    {
        return $this->sendRespondSuccess($pub, 'Show pub successfully!');
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
    public function destroy(Pub $pub)
    {
        $pub->delete();
        return $this->sendRespondSuccess($pub, 'Delete successfully!');
    }
}
