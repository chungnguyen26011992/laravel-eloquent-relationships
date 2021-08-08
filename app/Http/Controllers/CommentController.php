<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getParentModelOfComment(Request $request) {
        $comment = Comment::find(1);
        $commentable = $comment->commentable;
        return $commentable;
    }
}
