<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::get();
        $posts = Post::get();
        foreach ($users as $user) {
            $width = mt_rand(300, 800);
            $height = mt_rand(300, 800);
            Image::create([
                'url' => 'https://via.placeholder.com/' . $width . 'x' . $height,
                'imageable_id' => $user->id,
                'imageable_type' => User::class,
            ]);
        }

        foreach ($posts as $post) {
            $width = mt_rand(300, 800);
            $height = mt_rand(300, 800);
            Image::create([
                'url' => 'https://via.placeholder.com/' . $width . 'x' . $height,
                'imageable_id' => $post->id,
                'imageable_type' => Post::class,
            ]);
        }
        return $users;
    }

    public function getPhoneOfUser($id, Request $request) {
        $phone = User::find($id)->phone;
        return $phone;
    }

    public function getPostsOfUser($id, Request $request) {
        $posts = User::find($id)->posts;
        return $posts;
    }
}
