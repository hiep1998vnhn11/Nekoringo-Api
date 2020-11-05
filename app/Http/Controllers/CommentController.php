<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Pub;
use Illuminate\Http\Request;

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
