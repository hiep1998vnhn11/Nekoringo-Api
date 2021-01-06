<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Pub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function create(CommentRequest $request, Pub $pub)
    {
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->pub_id = $pub->id;
        $comment->content = $request->content;
        $image_photo_path = null;
        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $uploadFolder = 'pubs/' . $pub->id . '/comment';
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image_photo_path = $image->storeAs($uploadFolder, $imageName, 's3');
            Storage::disk('s3')->setVisibility($image_photo_path, 'public');
            $path = Storage::disk('s3')->url($image_photo_path);
        }
        if ($path) $comment->image_path = $path;
        $comment->save();
        return $this->sendRespondSuccess($comment, 'Create comment Successfully!');
    }

    public function delete(Comment $comment)
    {
        if ($comment->user_id != auth()->user()->id) return $this->sendForbidden();
        $comment->delete();
        return $this->sendRespondSuccess($comment, 'Deleted!');
    }
}
