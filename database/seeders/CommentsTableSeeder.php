<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::get();
        $videos = Video::get();

        Comment::truncate();
    }
}
