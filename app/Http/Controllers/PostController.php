<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getUserByPost($id, Request $request) {
        $user = Post::find($id)->user;
        return $user;
    }

    public function getImageOfPost($id, Request $request) {
        $image = Post::find($id)->image;
        return $image;
    }

    public function getCommentsOfPost($id, Request $request) {
        $comments = Post::find($id)->comments;
        return $comments;
    }
}
