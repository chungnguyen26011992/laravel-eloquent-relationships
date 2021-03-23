<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Container::getInstance()->make(Generator::class);

        for($i = 0; $i <= 20; $i++) {
            $post         = new Post;
            $post->name   = $faker->realText($maxNbChars = 20, $indexSize = 2);
            $post->slug   = 'post-' . $i;
            $post->description = $faker->realText($maxNbChars = 200, $indexSize = 2);
            $post->author_id = mt_rand(1, 10);
            $post->order = 1;
            $post->status = 1;
            $post->save();
        }
    }
}
