<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videos = [];
        for ($i = 1; $i <= 10; $i++) {
            $videos[] = [
                'title' => 'Video ' . $i,
                'url' => 'video-' . $i . '.mp4',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Video::insert($videos);
    }
}
