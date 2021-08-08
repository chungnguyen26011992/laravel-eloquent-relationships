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

        foreach ($posts as $post) {
            $body = 'Comment Post ' . $post->id;
            Comment::create([
                'body' => $body,
                'commentable_id' => $post->id,
                'commentable_type' => Post::class,
            ]);
        }

        foreach ($videos as $video) {
            $body = 'Comment Video ' . $video->id;
            Comment::create([
                'body' => $body,
                'commentable_id' => $video->id,
                'commentable_type' => Video::class,
            ]);
        }
    }
}
