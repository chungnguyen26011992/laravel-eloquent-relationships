<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $posts = Post::get();
        Image::truncate();

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
    }
}
